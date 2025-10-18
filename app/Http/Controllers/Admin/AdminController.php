<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function orders()
    {
        return view('admin.orders.index');
    }

    public function showOrder($id)
    {
        return view('admin.orders.show', compact('id'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        // Cập nhật trạng thái đơn hàng (ví dụ)
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }

    public function confirmOrder($id)
    {
        // Xác nhận đơn hàng
        return redirect()->back()->with('success', 'Đã xác nhận đơn hàng');
    }

    public function toggleUserAdmin($user)
    {
        // Xử lý bật/tắt quyền admin
        return redirect()->back()->with('success', 'Cập nhật quyền admin thành công');
    }
}
