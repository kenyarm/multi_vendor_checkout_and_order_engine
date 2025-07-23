<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->get();
        return view('orders.index')->with(['orders' => $orders]);
    }

    public function show(Order $order)
    {
        return view('orders.show')->with(['order' => $order]);
    }

    public function adminOrders()
    {
        $query = Order::with(['user', 'vendor', 'payment'])->orderBy('created_at', 'desc');

        $vendorId = request()->get('vendor_id');
        $userId = request()->get('user_id');
        $requestStatus = request()->get('status');

        $query->when($vendorId, function ($q) use ($vendorId) {
            return $q->where('vendor_id', $vendorId);
        });
        
        $query->when($userId, function ($q) use ($userId) {
            return $q->where('user_id', $userId);
        });

        $query->when($requestStatus, function ($q) use ($requestStatus) {
            return $q->whereHas('payment', function ($query) use ($requestStatus) {
                return $query->where('status', $requestStatus);
            });
        });

        $orders = $query->get();

        // You can fetch these for the filter dropdowns
        $vendors = \App\Models\Vendor::all();
        $users = \App\Models\User::get(); 
        $statuses = ['pending', 'paid']; // Customize as needed

        return view('admin.orders.index', compact('orders', 'vendors', 'users', 'statuses'));
    }

    public function adminOrderShow(Order $order)
    {
        return view('admin.orders.show')->with(['order' => $order]);
    }

}
