<?php

namespace App\Http\Controllers;

class CashierController extends Controller
{
    public function pos()
    {
        return view('cashier.pos');
    }
}
