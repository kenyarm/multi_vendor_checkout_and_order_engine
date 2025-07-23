<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getOrCreateCart();
        return view('cart.index')->with([
            'cart' => $cart->load('items.product')
        ]);
    }

    public function addToCart(Request $request, int $productId)
    {
        $quantity = $request->input('quantity', 1);
        $cart = $this->cartService->addToCart($productId, $quantity);
        return redirect()->route('home')->with('success', 'Product added to cart successfully!');
    }

    public function viewCart()
    {
        $cart = $this->cartService->viewCart();
        return view('cart.view', compact('cart'));
    }

    public function remove(CartItem $cartItem)
    {
        $this->cartService->removeItem($cartItem->id);
        return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully!');
    }

    public function clear()
    {
        $this->cartService->clearCart();
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}
