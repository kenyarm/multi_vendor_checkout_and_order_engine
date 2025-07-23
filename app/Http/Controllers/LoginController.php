<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;


class LoginController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ]);

        $oldSessionId = session()->getId(); // Capture old session ID before login

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate(); // Regenerate session for security
            $newSessionId = session()->getId(); // Capture new session ID after login

            $user = Auth::user();
            $sessionCart = Cart::where('session_id', $oldSessionId)->with('items')->first();
            if ($sessionCart) {
                $userCart = Cart::updateOrCreate(
                    ['user_id' => $user->id],
                    ['session_id' => $newSessionId]
                );

                foreach ($sessionCart->items as $item) {
                    $existing = $userCart->items()->where('product_id', $item->product_id)->first();

                    if ($existing) {
                        $existing->quantity += $item->quantity; // Merge quantity
                        $existing->total = $existing->quantity * $existing->price;
                        $existing->save();
                    } else {
                        $userCart->items()->create([
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'total' => $item->total,
                        ]);
                    }
                }
            }
            return redirect()->intended(); // Redirect after login
        }

        // If login fails
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request)
    {
        $oldSessionId = session()->getId(); // Save current session ID

        auth()->logout();

        // Manually regenerate session (Laravel does this by default)
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();

        $newSessionId = session()->getId(); // New session ID after logout

        // Move session cart to new session
        $cart = Cart::where('session_id', $oldSessionId)->first();
        if ($cart) {
            $cart->session_id = $newSessionId;
            $cart->save();
        }

        return redirect()->route('home');
    }
}
