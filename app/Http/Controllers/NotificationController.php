<?php

namespace App\Http\Controllers;

use App\Models\CashierStock;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\StockRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $stockRequests = StockRequest::with(['cashier', 'product'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $pendingCount = $stockRequests->count();

        return view('admin.notifications', compact('stockRequests', 'pendingCount'));
    }

    public function cashierIndex()
    {
        // Mark all as seen
        StockRequest::where('cashier_id', Auth::id())
            ->whereNull('seen_at')
            ->update(['seen_at' => now()]);

        $notifications = StockRequest::with(['product', 'approver'])
            ->where('cashier_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'rejected', 'on_hold'])
            ->latest()
            ->get();

        return view('cashier.notifications', compact('notifications'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $stockRequest = StockRequest::with('product')->findOrFail($id);

        if ($stockRequest->status !== 'pending') {
            return back()->with('error', 'This request was already processed.');
        }

        $quantity = (int) $request->quantity;
        $product = $stockRequest->product;

        if ($product->stock_quantity < $quantity) {
            return back()->with('error', 'Not enough stock! Warehouse has ' . $product->stock_quantity . ' left.');
        }

        DB::transaction(function () use ($stockRequest, $product, $quantity) {
            // decrease admin warehouse
            $product->decrement('stock_quantity', $quantity);

            // increase cashier stock
            $cashierStock = CashierStock::where('cashier_id', $stockRequest->cashier_id)
                ->where('product_id', $stockRequest->product_id)
                ->first();

            if ($cashierStock) {
                $cashierStock->increment('allocated_quantity', $quantity);
            } else {
                CashierStock::create([
                    'product_id' => $stockRequest->product_id,
                    'cashier_id' => $stockRequest->cashier_id,
                    'allocated_quantity' => $quantity,
                    'sold_quantity' => 0,
                    'allocated_by' => Auth::id(),
                ]);
            }

            // log movement
            StockMovement::create([
                'product_id' => $stockRequest->product_id,
                'type' => 'out',
                'quantity' => $quantity,
                'reason' => 'Transfer to ' . User::find($stockRequest->cashier_id)->name,
                'user_id' => Auth::id(),
            ]);

            // mark request approved
            $stockRequest->update([
                'status' => 'approved',
                'quantity_approved' => $quantity,
                'approved_by' => Auth::id(),
                'seen_at' => null,
            ]);
        });

        return back()->with('success', 'Stock transferred!');
    }

    public function reject(Request $request, $id)
    {
        StockRequest::findOrFail($id)->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'dispute_reason' => $request->reason,
            'seen_at' => null,
        ]);
        return back()->with('success', 'Request rejected');
    }

    public function returnStock(Request $request)
    {
        $req = StockRequest::findOrFail($request->request_id);

        $cashierStock = CashierStock::where('cashier_id', Auth::id())
            ->where('product_id', $req->product_id)
            ->first();

        if ($cashierStock) {
            $cashierStock->decrement('allocated_quantity', $request->quantity);
        }

        StockMovement::create([
            'product_id' => $req->product_id,
            'type' => 'out',
            'quantity' => $request->quantity,
            'reason' => 'Loss: ' . $request->reason . ' - ' . Auth::user()->name,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Broken stock reported.']);
    }

    public function markSingleRead($id)
    {
        StockRequest::where('id', $id)
            ->where('cashier_id', Auth::id()) // add this
            ->update(['seen_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function markRead()
    {
        StockRequest::where('cashier_id', Auth::id())
            ->whereNull('seen_at')
            ->update(['seen_at' => now()]);

        return response()->json(['success' => true]);
    }
}
