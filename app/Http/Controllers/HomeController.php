<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CartService;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all();
        $cartService = new CartService();
        $cart = $cartService->getOrCreateCart();
        
        return view('index')->with([
            'products' => $products,
            'cart' => $cart
        ]);
    }


    public function adminDashboard()
    {
        $ordersCount = Order::count();
        $productsCount = Product::count();
        $vendorsCount = \App\Models\Vendor::count(); 

        $usersCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->count(); 
        
        $adminsCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->count();

        return view('admin.dashboard')->with([
            'ordersCount' => $ordersCount,
            'productsCount' => $productsCount,
            'usersCount' => $usersCount,
            'adminsCount' => $adminsCount,
            'vendorsCount' => $vendorsCount
        ]);
    }
}
