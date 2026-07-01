<?php

namespace App\Http\Controllers;

use App\Helpers\InventoryData;
use App\Models\Categories;
use App\Models\Product;
use App\Models\StockMovement;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                        ->orWhere('code', 'like', '%'.$search.'%')
                        ->orWhere('barcode', 'like', '%'.$search.'%')
                        ->orWhereHas('category', function ($cat) use ($search) {
                            $cat->where('name', 'like', '%'.$search.'%');
                        });
                });
            })
            ->with('category')
            ->get();

        $categories = Categories::withCount([
            'products as total_stock' => function ($q) {
                $q->select(\DB::raw('COALESCE(sum(stock_quantity), 0)'));
            },
        ])->get();

        // Mock data not yet migrated
        $summary = InventoryData::getSummary();
        $summaryCards = InventoryData::getSummaryCards();
        $trend = $this->getMovementTrend($request);

        if ($request->ajax === '1') {

            $html = view('admin.partials.products.table-rows', compact('products'))->render();

            return response()->json(['table' => $html]);
        }

        return view('admin.inventory', compact('products', 'categories', 'summary', 'summaryCards', 'trend'));
    }

    private function getMovementTrend(Request $request)
    {

        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        if ($request->start_date && $request->end_date) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
        } else {
            $days = (int) $request->get('range', 7); // default 7
            $startDate = now()->subDays($days - 1)->startOfDay();
            $endDate = now()->endOfDay();
        }

        $movements = StockMovement::orderBy('created_at')->get();

        if ($movements->isEmpty()) {
            return [
                'labels' => [],
                'stock_in' => [],
                'stock_out' => [],
            ];
        }

        $grouped = $movements->groupBy(function ($item) {
            return $item->created_at->format('M d');
        });

        $labels = [];
        $stockIn = [];
        $stockOut = [];

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $dayKey = $date->format('Y-m-d');
            $labels[] = $date->format('M d');

            $dayMovements = $movements->filter(function ($item) use ($dayKey) {
                return $item->created_at->format('Y-m-d') === $dayKey;
            });

            $stockIn[] = $dayMovements->where('type', 'in')->sum('quantity');
            $stockOut[] = $dayMovements->where('type', 'out')->sum('quantity');
        }

        foreach ($grouped as $time => $items) {
            $labels[] = $time;
            $stockIn[] = $items->where('type', 'in')->sum('quantity');
            $stockOut[] = $items->where('type', 'out')->sum('quantity');
        }

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayKey = $date->format('Y-m-d');
            $labels[] = $date->format('M d');

            $dayMovements = $movements->filter(function ($item) use ($dayKey) {
                return $item->created_at->format('Y-m-d') === $dayKey;
            });

            $stockIn[] = $dayMovements->where('type', 'in')->sum('quantity');
            $stockOut[] = $dayMovements->where('type', 'out')->sum('quantity');
        }

        return [
            'labels' => $labels,
            'stock_in' => $stockIn,
            'stock_out' => $stockOut,
        ];
    }

    public function adjustStock(Request $request)
    {
        $request->validate([
            'product_code' => 'required|exists:products,code',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:0',
            'reason' => 'required|string',
            'notes' => 'nullable|string',
            'low_stock_threshold' => 'nullable|integer|min:0',
        ]);

        $product = Product::where('code', $request->product_code)->firstOrFail();

        if ($request->type === 'in') {
            $product->increment('stock_quantity', $request->quantity);
        } else {
            if ($product->stock_quantity < $request->quantity) {
                return response()->json(['error' => 'Not enough stock to remove that quantity'], 422);
            }
            $product->decrement('stock_quantity', $request->quantity);
        }

        if ($request->low_stock_threshold !== null) {
            $product->update(['low_stock_threshold' => $request->low_stock_threshold]);
        }

        StockMovement::create([
            'product_id' => $product->id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'user_id' => Auth::id(),
        ]);

        // Always update threshold if provided
        if ($request->low_stock_threshold !== null) {
            $product->update(['low_stock_threshold' => $request->low_stock_threshold]);
        }

        return response()->json(['message' => 'Stock adjusted', 'new_stock' => $product->stock_quantity, 'low_stock_threshold' => $product->low_stock_threshold]);
    }

    public function export(Request $request)
    {
        $products = Product::with('category')->get();
        $movements = StockMovement::whereBetween('created_at', [
            now()->subDays(6)->startOfDay(),
            now()->endOfDay(),
        ])->get();

        $filename = 'inventory_'.now()->format('Y_m_d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($products, $movements) {
            $file = fopen('php://output', 'w');

            // ── Section 1: Summary ──
            fputcsv($file, ['INVENTORY SUMMARY']);
            fputcsv($file, ['Metric', 'Value']);
            fputcsv($file, ['Total Products', $products->count()]);
            fputcsv($file, ['Low Stock', $products->filter(fn ($p) => $p->stock_quantity > 0 && $p->stock_quantity <= $p->low_stock_threshold)->count()]);
            fputcsv($file, ['Out of Stock', $products->where('stock_quantity', 0)->count()]);
            fputcsv($file, ['Stock Value ($)', number_format($products->sum(fn ($p) => $p->stock_quantity * $p->selling_price), 2)]);
            fputcsv($file, []); // empty row spacer

            // ── Section 2: Products ──
            fputcsv($file, ['PRODUCT INVENTORY']);
            fputcsv($file, ['Name', 'Code', 'Category', 'Stock', 'Low Stock Threshold', 'Status', 'Selling Price', 'Last Updated']);
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->code,
                    $product->category->name ?? 'Unassigned',
                    $product->stock_quantity,
                    $product->low_stock_threshold,
                    ucfirst($product->status),
                    '$'.number_format($product->selling_price, 2),
                    $product->updated_at->format('M d, Y H:i'),
                ]);
            }
            fputcsv($file, []); // spacer

            // ── Section 3: Stock Movement (last 7 days raw numbers) ──
            fputcsv($file, ['STOCK MOVEMENTS (Last 7 Days)']);
            fputcsv($file, ['Date', 'Stock In', 'Stock Out']);

            // Group by day
            $grouped = collect();
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $label = now()->subDays($i)->format('M d, Y');
                $dayMovements = $movements->filter(fn ($m) => $m->created_at->format('Y-m-d') === $date);
                fputcsv($file, [
                    $label,
                    $dayMovements->where('type', 'in')->sum('quantity'),
                    $dayMovements->where('type', 'out')->sum('quantity'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
