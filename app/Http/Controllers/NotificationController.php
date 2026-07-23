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
            ->whereIn('status', ['pending', 'loss_reported'])
            ->latest()
            ->get()
            ->groupBy(function ($req) {
                $days = $req->created_at->diffInDays(now());
                if ($days == 0) return 'Today';
                if ($days == 1) return 'Yesterday';
                if ($days >= 2 && $days <= 6) return $days . ' days ago';
                if ($days >= 7 && $days <= 13) return '1 week ago';
                if ($days >= 14 && $days <= 20) return '2 weeks ago';
                return 'Older';
            });

        return view('admin.notifications', compact('stockRequests'));
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
            ->get()
            ->groupBy(function ($notif) {
                $days = $notif->created_at->diffInDays(now());
                if ($days == 0) return 'Today';
                if ($days == 1) return 'Yesterday';
                if ($days >= 2 && $days <= 6) return $days . ' days ago';
                if ($days >= 7 && $days <= 13) return '1 week ago';
                return 'Older';
            });

        return view('cashier.notifications', compact('notifications'));
    }

    public function approve(Request $request, $id)
    {

        $stockRequest = StockRequest::with('product')->findOrFail($id);

        if ($stockRequest->status !== 'pending') {
            return back()->with('error', 'This request was already processed.');
        }

        // New product - no stock, just approve
        if (!$stockRequest->product_id) {
            $stockRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'seen_at' => null,
            ]);
            return back()->with('success', 'Request acknowledged');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

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

    public function markAllRead()
    {
        StockRequest::whereIn('status', ['pending', 'loss_reported'])
            ->whereNull('seen_at')
            ->update(['seen_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function markSingle($id)
    {
        StockRequest::where('id', $id)->update(['seen_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function returnStock(Request $request)
    {
        $cashierStock = CashierStock::where('cashier_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cashierStock) {
            $remaining = $cashierStock->allocated_quantity - $cashierStock->sold_quantity;
            if ($request->quantity > $remaining) {
                return response()->json(['message' => 'Cannot report more than available'], 422);
            }
            $cashierStock->decrement('allocated_quantity', $request->quantity);
        }

        StockMovement::create([
            'product_id' => $request->product_id,
            'type' => 'out',
            'quantity' => $request->quantity,
            'reason' => 'Loss: ' . $request->reason . ' - ' . Auth::user()->name,
            'user_id' => Auth::id(),
        ]);

        // Notify admin
        StockRequest::create([
            'cashier_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity_requested' => $request->quantity,
            'status' => 'loss_reported',
            'cashier_notes' => $request->reason,
            'seen_at' => null,
        ]);

        return response()->json(['message' => 'Loss reported']);
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
