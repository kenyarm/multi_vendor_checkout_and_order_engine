<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Services\CartService;

class ViewCartButton extends Component
{
    public $cart;
    /**
     * Create a new component instance.
     */
    public function __construct(CartService $cartService)
    {
        $this->cart = $cartService->getOrCreateCart();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.view-cart-button');
    }
}
