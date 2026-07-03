<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        $customers = Customer::where('name', 'like', '%'.$request->q.'%')
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
}
