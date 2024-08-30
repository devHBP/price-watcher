<?php

namespace App\Http\Controllers;

use App\Models\Produits;

class DashboardController extends Controller
{
    public function index()
    {
        $produits = Produits::all();
        return view('dashboard', ['produits' => $produits ]);
    }
}