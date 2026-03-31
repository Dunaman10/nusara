<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  public function index()
  {
    $query = Order::query();
    
    if (Auth::user()->role->role_name !== 'super_admin') {
      $query->where('restaurant_id', Auth::user()->restaurant_id);
    }
    
    $orders = $query->orderByDesc('created_at')->get();

    return view('admin.order.index', compact('orders'));
  }

  public function show($id)
  {
    $order = Order::findOrFail($id);
    
    if (Auth::user()->role->role_name !== 'super_admin' && $order->restaurant_id !== Auth::user()->restaurant_id) {
       abort(403, 'Unauthorized action.');
    }
    
    $orderItems = OrderItem::where('order_id', $order->id)->get();

    return view('admin.order.show', compact('order', 'orderItems'));
  }

  public function updateStatus($id)
  {
    $order = Order::findOrFail($id);
    
    if (Auth::user()->role->role_name !== 'super_admin' && $order->restaurant_id !== Auth::user()->restaurant_id) {
       abort(403, 'Unauthorized action.');
    }

    if (Auth::user()->role->role_name == 'admin' || Auth::user()->role->role_name == 'super_admin' || Auth::user()->role->role_name == 'cashier') {
      $order->status = 'settlement';
    } elseif (Auth::user()->role->role_name == 'chef') {
      $order->status = 'cooked';
    }
    $order->save();

    return redirect()->route('orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
  }
}
