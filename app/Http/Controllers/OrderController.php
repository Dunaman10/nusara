<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
  public function index()
  {
    $orders = Order::all()->sortByDesc('created_at');

    return view('admin.order.index', compact('orders'));
  }
}
