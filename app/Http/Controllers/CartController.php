<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    // Đổi tên method từ addToCart thành add để khớp với route
    public function add(Request $request, $productId)
    {
        $product = Product::with(['images'])->find($productId);
        
        if (!$product) {
            return back()->with('error', 'Sản phẩm không tồn tại!');
        }

        $cart = session()->get('cart', []);
        $quantity = $request->quantity ?? 1;

        // Debug: In ra thông tin sản phẩm
        \Log::info('Product data:', [
            'product' => $product->toArray(),
            'images' => $product->images->toArray()
        ]);

        // Lấy hình ảnh sản phẩm - kiểm tra nhiều trường hợp
        $imagePath = 'default.jpg';
        
        // Kiểm tra nếu có quan hệ mainImage
        if ($product->relationLoaded('mainImage') && $product->mainImage) {
            $imagePath = $product->mainImage->path;
        } 
        // Kiểm tra nếu có images
        elseif ($product->images && $product->images->count() > 0) {
            $imagePath = $product->images->first()->path;
        }
        // Kiểm tra trường image trực tiếp trong bảng products
        elseif (isset($product->image) && $product->image) {
            $imagePath = $product->image;
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $imagePath
            ];
        }

        session()->put('cart', $cart);

        // Debug: In ra giỏ hàng
        \Log::info('Cart after adding:', session()->get('cart'));

        if ($request->has('buy_now')) {
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function updateQuantity(Request $request, $id)
    {
        \Log::info('Update quantity called', ['id' => $id, 'change' => $request->input('change')]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $change = $request->input('change', 0);
            $cart[$id]['quantity'] += $change;
            
            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
            }
            
            session()->put('cart', $cart);
            
            \Log::info('Cart updated', ['cart' => $cart]);
            
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật số lượng',
                'cart_count' => count($cart)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
        ]);
    }

    public function removeFromCart(Request $request, $id)
    {
        \Log::info('Remove from cart called', ['id' => $id]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            \Log::info('Product removed, cart now:', $cart);
            
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                'cart_count' => count($cart)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
        ]);
    }

    public function clearCart(Request $request)
    {
        \Log::info('Clear cart called');
        
        session()->forget('cart');
        
        \Log::info('Cart cleared');
        
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ giỏ hàng'
        ]);
    }
}