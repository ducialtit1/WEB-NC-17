<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Hiển thị trang dashboard admin
     */
    public function dashboard()
    {
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'users' => User::count(),
            'revenue' => Order::where('status', 'completed')->sum('total')
        ];
        
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * Hiển thị danh sách sản phẩm
     */
    public function products()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }
    
    /**
     * Hiển thị form tạo sản phẩm
     */
    public function createProduct()
    {
        return view('admin.products.create');
    }
    
    /**
     * Lưu sản phẩm mới
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'size' => 'required|string|max:10',
            'type' => 'required|in:food,drink',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $product = new Product();
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->size = $validated['size'];
        $product->type = $validated['type'];
        $product->slug = Str::slug($validated['name']); 
        $product->save();
        
        // Xử lý hình ảnh
        if ($request->hasFile('main_image')) {
            $image = $request->file('main_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('imgs'), $imageName);
            
            $product->images()->create([
                'path' => $imageName,
                'is_main' => true
            ]);
        }
        
        return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được tạo thành công');
    }
    
    /**
     * Hiển thị form chỉnh sửa sản phẩm
     */
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }
    
    /**
     * Cập nhật sản phẩm
     */
    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'size' => 'required|string|max:10',
            'type' => 'required|in:food,drink',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $product = Product::findOrFail($id);
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->size = $validated['size'];
        $product->type = $validated['type'];
        $product->slug = Str::slug($validated['name']);
        $product->save();
        
        // Xử lý hình ảnh nếu có
        if ($request->hasFile('main_image')) {
            // Xóa ảnh cũ nếu là ảnh chính
            if ($product->mainImage) {
                $oldImagePath = public_path('imgs/' . $product->mainImage->path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $product->mainImage->delete();
            }
            
            $image = $request->file('main_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('imgs'), $imageName);
            
            $product->images()->create([
                'path' => $imageName,
                'is_main' => true
            ]);
        }
        
        return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được cập nhật thành công');
    }
    
    /**
     * Xóa sản phẩm
     */
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Xóa các hình ảnh liên quan
        foreach ($product->images as $image) {
            $imagePath = public_path('imgs/' . $image->path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }
        
        $product->delete();
        
        return redirect()->route('admin.products')->with('success', 'Sản phẩm đã được xóa thành công');
    }
    
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function showOrder($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);
        
        $order = Order::findOrFail($id);
        $order->status = $validated['status'];
        $order->save();
        
        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Trạng thái đơn hàng đã được cập nhật');
    }
    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);
        
        // Chỉ cho phép xác nhận đơn hàng ở trạng thái chờ xử lý
        if ($order->status !== 'pending') {
            return back()->with('error', 'Đơn hàng này không thể xác nhận vì không ở trạng thái chờ xử lý.');
        }
        
        $order->status = 'processing';
        $order->confirmed_at = now();
        $order->save();
        
        return back()->with('success', 'Đơn hàng #' . $order->id . ' đã được xác nhận thành công.');
    }
    /**
     * Hiển thị danh sách bình luận chờ duyệt
     */
    public function comments(Request $request)  // Đảm bảo tham số $request được khai báo ở đây
    {
        $query = Comment::with(['product', 'user']);
        
        // Áp dụng bộ lọc
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false)->where('is_rejected', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'rejected') {
                $query->where('is_rejected', true);
            }
        }
        
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $comments = $query->latest()->paginate(10);
        
        // Lấy các số liệu thống kê
        $pendingCount = Comment::where('is_approved', false)->where('is_rejected', false)->count();
        $approvedCount = Comment::where('is_approved', true)->count();
        $rejectedCount = Comment::where('is_rejected', true)->count();
        
        // Lấy danh sách sản phẩm cho filter
        $products = Product::select('id', 'name')->orderBy('name')->get();
        
        return view('admin.comments.index', compact(
            'comments', 
            'pendingCount', 
            'approvedCount', 
            'rejectedCount',
            'products'
        ));
    }
    
    /**
     * Phê duyệt bình luận
     */
    public function approveComment(Comment $comment)
    {
        $comment->is_approved = true;
        $comment->is_rejected = false;
        $comment->save();
        
        return back()->with('success', 'Bình luận đã được duyệt thành công.');
    }
    
    public function rejectComment(Comment $comment)
    {
        $comment->is_approved = false;
        $comment->is_rejected = true;
        $comment->save();
        return back()->with('success', 'Bình luận đã bị từ chối.');
    }
    /**
     * Xóa bình luận
     */
    public function destroyComment(Comment $comment)
    {
        $comment->delete();
        
        return back()->with('success', 'Bình luận đã được xóa thành công.');
    }
    
    /**
     * Hiển thị danh sách người dùng
     */
    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Cập nhật quyền admin cho người dùng
     */
    public function toggleUserAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = !$user->is_admin;
        $user->save();
        
        return redirect()->route('admin.users')->with('success', 'Quyền admin đã được cập nhật');
    }
}