<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session('cart', []);

        $cart[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'size' => $product->size ?? null,
            'price' => $product->price,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + $qty,
        ];

        session(['cart' => $cart]);

        // Trả JSON để cập nhật badge trên navbar khi thêm bằng AJAX
        if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'ok' => true,
                'cart_count' => collect($cart)->sum('quantity'),
            ]);
    }

    return redirect()->route('cart.index');
    }

    public function remove(Request $request, $id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'cart_count' => collect($cart)->sum('quantity')]);
        }

        return redirect()->route('cart.index');
    }
}