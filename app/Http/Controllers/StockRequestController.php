<?php

namespace App\Http\Controllers;

use App\Models\StockRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StockRequestController extends Controller
{
    public function store(Request $request)
    {
        StockRequest::create([
            'cashier_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity_requested' => $request->quantity,
        ]);
        return response()->json(['message' => 'Request sent to admin']);
    }

    public function index()
    {
        $requests = StockRequest::with(['cashier', 'product'])
            ->where('status', 'pending')->latest()->get();
        return view('admin.stock-requests', compact('requests'));
    }
}
