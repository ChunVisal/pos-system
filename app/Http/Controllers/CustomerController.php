<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::whereHas('orders', function ($q) {
            $q->where('cashier_id', Auth::id());
        })
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('phone', 'like', '%'.$request->search.'%');
            })
            ->withCount(['orders as total_orders' => function ($q) {
                $q->where('cashier_id', Auth::id());
            }])
            ->withSum(['orders as total_spent' => function ($q) {
                $q->where('cashier_id', Auth::id());
            }], 'total')
            ->orderBy('last_order_at', 'desc')
            ->get();

        return view('cashier.customers', compact('customers'));
    }

    public function search(Request $request)
    {
        $customers = Customer::whereHas('orders', function ($q) {
            $q->where('cashier_id', Auth::id());
        })
            ->where('name', 'like', '%'.$request->q.'%')
            ->orWhere('phone', 'like', '%'.$request->q.'%')
            ->limit(5)
            ->get();

        return response()->json($customers);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'phone' => 'required|unique:customers']);
        $customer = Customer::create($request->all());

        return response()->json(['customer' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return response()->json(['customer' => $customer]);
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->avg_order = $customer->total_orders > 0
            ? $customer->total_spent / $customer->total_orders
            : 0;

        $orders = Order::with('payment', 'items')
            ->where('customer_id', $id)
            ->where('cashier_id', Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        // Calculate stats from filtered orders only
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total');
        $customer->total_orders = $totalOrders;
        $customer->total_spent = $totalSpent;
        $customer->avg_order = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;

        return response()->json([
            'customer' => $customer,
            'orders' => $orders,
        ]);
    }
}
