<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'type'        => 'required|in:food,drink',
            'size'        => 'required|string|max:10',
            'description' => 'nullable|string',
            'main_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = new Product();
        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);
        $product->price = $validated['price'];
        $product->type = $validated['type'];
        $product->size = $validated['size'];
        $product->description = $validated['description'] ?? null;
        $product->category_id = $validated['type'] === 'food' ? 1 : 2;
        $product->save();

        // ✅ Lưu ảnh chính vào bảng product_images
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $ext = $file->getClientOriginalExtension();
            $filename = Str::random(40) . '.' . $ext;
            $file->move(public_path('imgs'), $filename);

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $filename,
                'is_main' => true,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', '✅ Đã thêm sản phẩm thành công.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'type'        => 'required|in:food,drink',
            'size'        => 'required|string|max:10',
            'description' => 'nullable|string',
            'main_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'price' => $validated['price'],
            'type' => $validated['type'],
            'size' => $validated['size'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['type'] === 'food' ? 1 : 2,
        ]);

        // ✅ Cập nhật ảnh chính
        if ($request->hasFile('main_image')) {
            // Xóa ảnh chính cũ (nếu có)
            $oldMain = $product->images()->where('is_main', true)->first();
            if ($oldMain) {
                Storage::disk('public')->delete($oldMain->path);
                $oldMain->delete();
            }

            // Thêm ảnh mới
            $file = $request->file('main_image');
            $ext = $file->getClientOriginalExtension();
            $filename = Str::random(40) . '.' . $ext;
            $file->move(public_path('imgs'), $filename);

            $product->images()->create([
                'path' => $filename,
                'is_main' => true,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', '✅ Cập nhật sản phẩm thành công.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', '🗑️ Đã xóa sản phẩm.');
    }
}