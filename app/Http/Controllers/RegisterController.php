<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cart;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('customer'); // Assign default role
        $oldSessionId = session()->getId(); // Store session before login

        Auth::login($user); // ✅ Don't check return

        $request->session()->regenerate(); // Security
        $newSessionId = session()->getId();

        // Merge cart from session to user
        $sessionCart = Cart::where('session_id', $oldSessionId)->with('items')->first();
        if ($sessionCart) {
            $userCart = Cart::updateOrCreate(
                ['user_id' => $user->id],
                ['session_id' => $newSessionId]
            );

            foreach ($sessionCart->items as $item) {
                $existing = $userCart->items()->where('product_id', $item->product_id)->first();

                if ($existing) {
                    $existing->quantity += $item->quantity;
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

        return redirect()->intended(); // Success

    }
}
