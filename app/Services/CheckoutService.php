<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use App\Events\OrderPlaced;
use App\Events\PaymentSucceeded;
class CheckoutService
{
  public function checkout(User $user, string $status = 'pending')
  {
    if (!in_array($status, ['pending', 'paid'])) {
      throw new \InvalidArgumentException('Invalid status provided.');
    }

    $cart = $user->cart()->with('items')->first();

    if (!$cart || $cart->items->isEmpty()) {
      throw new \Exception('Cart is empty.');
    }

    $orders = [];

    DB::transaction(function () use ($user, $cart, $status, &$orders) {
      $productIds = $cart->items->pluck('product_id');

      // ✅ This now works correctly inside transaction
      $products = Product::whereIn('id', $productIds)
        ->lockForUpdate()
        ->get()
        ->keyBy('id');

      $stockErrors = [];

      foreach ($cart->items as $item) {
        $product = $products->get($item->product_id);

        if (!$product) {
          $stockErrors["product_{$item->product_id}"] = 'Product not found.';
        } elseif ($product->stock < $item->quantity) {
          $stockErrors["product_{$product->id}"] = "Insufficient stock for '{$product->name}'. Only {$product->stock} left.";
        }
      }

      if (!empty($stockErrors)) {
        throw ValidationException::withMessages($stockErrors);
      }

      $itemsByVendor = $cart->items->groupBy(fn($item) => $products->get($item->product_id)?->vendor_id);

      foreach ($itemsByVendor as $vendorId => $items) {
        $order = Order::create([
          'user_id' => $user->id,
          'vendor_id' => $vendorId,
          'total' => 0,
        ]);

        $total = 0;

        foreach ($items as $item) {
          $product = $products->get($item->product_id);
          $subtotal = $product->price * $item->quantity;
          $total += $subtotal;

          OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'quantity' => $item->quantity,
            'total' => $subtotal,
          ]);

          $product->decrement('stock', $item->quantity);
        }

        $order->update(['total' => $total]);
        event(new OrderPlaced($order));

        Payment::create([
          'order_id' => $order->id,
          'status' => $status,
        ]);

        if ($status === 'paid') {
          event(new PaymentSucceeded($order->payment));
        }
        $orders[] = $order;
      }

      // Clear cart
      $cart->items()->delete();
      $cart->delete();

      // Optionally, you can also clear the session cart if needed
      $sessionId = session()->getId();
      Cart::where('session_id', $sessionId)->delete();

    });

    return $orders;
  }
}