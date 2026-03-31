<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index()
  {
    $query = Order::query();
    
    if (auth()->user()->role->role_name !== 'super_admin') {
      $query->where('restaurant_id', auth()->user()->restaurant_id);
    }
    
    $totalOrders = (clone $query)->count();
    $totalRevenue = (clone $query)->sum('grand_total');

    $todayOrders = (clone $query)->whereDate('created_at', now())->count();
    $todayRevenue = (clone $query)->whereDate('created_at', now())->sum('grand_total');

    return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'todayOrders', 'todayRevenue'));
  }
}
