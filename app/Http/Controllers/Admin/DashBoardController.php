<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng quan
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalUsers    = User::count();

        //đơn hàng theo trạng thái
        $pendingOrders    = Order::where('status', 'pending')->count();    // Chờ xử lý
        $processingOrders = Order::where('status', 'processing')->count(); // Đang giao
        $completedOrders  = Order::where('status', 'completed')->count();  // Hoàn thành
        $canceledOrders   = Order::where('status', 'canceled')->count();   // Đã hủy

        // Doanh thu
        $totalRevenue = Order::where('status', 'completed')->sum('total');

        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('updated_at', now()->toDateString())
            ->sum('total');

        $weekRevenue = Order::where('status', 'completed')
            ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total');

        //Đơn hàng gần đây
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'canceledOrders',
            'totalUsers',
            'totalRevenue',
            'todayRevenue',
            'weekRevenue',
            'recentOrders'
        ));
    }
}
