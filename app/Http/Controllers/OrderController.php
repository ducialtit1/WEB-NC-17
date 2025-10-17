<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Hiển thị trang checkout
     * Yêu cầu đăng nhập
     */
    public function checkout()
    {
        $cart = session('cart', []);
        
        // Kiểm tra giỏ hàng có trống không
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
        }
        
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        
        return view('checkout.index', compact('cart', 'total'));
    }
    
    /**
     * Xử lý đơn hàng và thanh toán
     * Yêu cầu đăng nhập
     */
    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);
        
        // Kiểm tra giỏ hàng có trống không
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }
        
        // Validate thông tin giao hàng
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Tạo đơn hàng
        $order = new Order();
        $order->user_id = Auth::id();
        $order->name = $validated['name'];
        $order->phone = $validated['phone'];
        $order->address = $validated['address'];
        $order->notes = $validated['notes'] ?? null;
        $order->payment_method = $validated['payment_method'];
        $order->total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $order->status = 'pending';
        $order->save();
        
        // Tạo các mục đơn hàng
        foreach ($cart as $id => $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $id;
            $orderItem->name = $item['name'];
            $orderItem->size = $item['size'] ?? null;
            $orderItem->price = $item['price'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->save();
        }
        
        // Xóa giỏ hàng
        Session::forget('cart');
        
        // Hiển thị kết quả thanh toán
        return redirect()->route('checkout.success', ['order' => $order->id]);
    }
    
    /**
     * Hiển thị trang đặt hàng thành công
     */
    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        
        // Kiểm tra đơn hàng thuộc về người dùng hiện tại
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('checkout.success', compact('order'));
    }
    
    /**
     * Hiển thị danh sách đơn hàng của người dùng
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('checkout.orders', compact('orders'));
    }
    
    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function showOrder($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        
        // Kiểm tra đơn hàng thuộc về người dùng hiện tại
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('checkout.order-detail', compact('order'));
    }
    public function cancel($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Kiểm tra đơn hàng thuộc về người dùng hiện tại
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Chỉ cho phép hủy đơn hàng đang chờ xử lý
        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy đơn hàng đang chờ xử lý.');
        }
        
        $order->status = 'cancelled';
        $order->save();
        
        return redirect()->route('my.orders')->with('success', 'Đơn hàng đã được hủy thành công.');
    }
}