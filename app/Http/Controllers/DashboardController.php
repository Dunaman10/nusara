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

    // Chart data: Pendapatan & Pesanan 7 hari terakhir
    $chartData = [];
    $barChartData = [];
    $chartLabels = [];
    
    for ($i = 6; $i >= 0; $i--) {
      $date = now()->subDays($i);
      $chartLabels[] = $date->format('d M');
      $chartData[] = (clone $query)->whereDate('created_at', $date)->sum('grand_total');
      $barChartData[] = (clone $query)->whereDate('created_at', $date)->count();
    }

    // Pie chart: Status Pesanan
    $pieChartData = [
      (clone $query)->where('status', 'pending')->count(),
      (clone $query)->where('status', 'settlement')->count(),
      (clone $query)->where('status', 'cooked')->count(),
    ];
    $pieChartLabels = ['Pending', 'Selesai Dibayar (Settlement)', 'Selesai Dimasak (Cooked)'];

    return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'todayOrders', 'todayRevenue', 'chartData', 'barChartData', 'chartLabels', 'pieChartData', 'pieChartLabels'));
  }
}
