<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
  public function getOrCreateCart(): Cart
  {
    $user = Auth::user();
    $sessionId = session()->getId();

    if ($user) {
      return Cart::firstOrCreate([
        'user_id' => $user->id,
        'session_id' => $sessionId,
      ]);
    } else {
      return Cart::firstOrCreate([
        'session_id' => $sessionId,
      ]);
    }
  }

  public function addToCart(int $productId, int $quantity = 1): Cart
  {
    $cart = $this->getOrCreateCart();

    $product = Product::find($productId);
    if (!$product) {
      throw new \Exception('Product not found');
    }
    $item = $cart->items()->where('product_id', $productId)->first();
    if ($item) {
      $item->increment('quantity', $quantity);
      $item->total = $item->quantity * $product->price;
      $item->save();
    } else {
      $cart->items()->create([
        'product_id' => $productId,
        'quantity' => $quantity,
        'price' => $product->price, // Assuming you have a Product model
        'total' => $product->price * $quantity,
      ]);
    }

    return $cart->load('items.product');
  }

  public function viewCart()
  {
    return $this->getOrCreateCart()->load('items.product');
  }

  public function removeItem(int $itemId)
  {
    $cart = $this->getOrCreateCart();
    $item = $cart->items()->find($itemId);
    if ($item) {
      $item->delete();
    } else {
      throw new \Exception('Item not found in cart');
    }
  }
  
  public function clearCart()
  {
    $cart = $this->getOrCreateCart();
    $cart->items()->delete();
    return $cart->load('items.product');
  }

  public function moveSessionCartToUser()
  {
    $user = Auth::user();
    if (!$user) {
      throw new \Exception('User not authenticated');
    }

    $sessionId = session()->getId();
    $cart = Cart::where('session_id', $sessionId)->first();

    if (!$cart) {
      throw new \Exception('No cart found for this session');
    }

    $userCart = Cart::firstOrCreate([
      'user_id' => $user->id,
    ]);

    foreach ($cart->items as $item) {
      $userCart->items()->updateOrCreate(
        ['product_id' => $item->product_id],
        [
          'quantity' => $item->quantity,
          'price' => $item->price,
          'total' => $item->total,
        ]
      );
    }
    
    return $userCart->load('items.product');
  }
}