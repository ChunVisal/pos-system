<?php

namespace App\Http\Controllers;

use App\Models\StockRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockRequestController extends Controller
{
    public function store(Request $request)
    {

        Log::info('Stock request data:', $request->all());
        StockRequest::create([
            'cashier_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity_requested' => $request->quantity,
            'cashier_notes' => $request->note,
        ]);
        return response()->json(['message' => 'Request sent to admin']);
    }

    public function bulkProductRequest(Request $request)
    {
        foreach ($request->items as $item) {
            StockRequest::create([
                'cashier_id' => Auth::id(),
                'product_name' => $item['name'],
                'quantity_requested' => $item['quantity'] ?? 1,
                'cashier_notes' => $item['note'] ?? null,
                'status' => 'pending',
            ]);
        }
        return response()->json(['message' => count($request->items) . ' requests sent']);
    }


    public function index()
    {
        $requests = StockRequest::with(['cashier', 'product'])
            ->where('status', 'pending')->latest()->get();
        return view('admin.stock-requests', compact('requests'));
    }
}
