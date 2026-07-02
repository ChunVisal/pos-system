<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function pos(Request $request)
    {

        $categories = Categories::withCount(['products as products_count'])->get();
        $products = Product::with('category')
            ->where('status', 'active')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('code', 'like', '%'.$request->search.'%')
                    ->orWhereHas('category', fn ($cat) => $cat->where('name', 'like', '%'.$request->search.'%'));
            })
            ->get();

        if ($request->ajax == '1') {
            $html = '';
            foreach ($products as $product) {
                $html .= view('cashier.partials.pos.table-rows', compact('product'))->render();
            }

            return $html;
        }

        $categoryCounts = [];
        foreach ($categories as $cat) {
            $categoryCounts[$cat->id] = $cat->products_count;
        }

        return view('cashier.pos', compact('categories', 'products', 'categoryCounts'));
    }

    public function checkout(Request $request)
    {
        // Handle checkout logic
        return response()->json(['success' => true, 'message' => 'Sale completed']);
    }
}
