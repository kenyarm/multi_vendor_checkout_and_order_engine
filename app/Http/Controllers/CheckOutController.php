<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{

    protected $checkoutService;
    protected $cartService;

    public function __construct(CartService $cartService, CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
        $this->cartService = $cartService;
    }

    public function checkout(Request $request)
    {
        $request->validate(['status' => 'required|in:pending,paid']);
        $user = $request->user();
        try {
            $orders = $this->checkoutService->checkout($user, $request->input('status', 'pending'));
            return redirect()->route('orders.index')->with('success', 'Checkout successful! Your orders have been placed.');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
