<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5',
        ]);
        
        $comment = new Comment();
        $comment->product_id = $product->id;
        $comment->content = $validated['content'];
        $comment->rating = $validated['rating'];
        
        // Nếu đã đăng nhập, lưu user_id
        if (Auth::check()) {
            $comment->user_id = Auth::id();
        } else {
            // Nếu là khách, lấy tên từ request (nếu có)
            $comment->guest_name = $request->input('guest_name', 'Khách');
        }
        
        // Tự động phê duyệt nếu là user đã đăng nhập
        if (Auth::check()) {
            $comment->is_approved = true;
        }
        
        $comment->save();
        
        return back()->with('success', 'Cảm ơn bạn đã gửi đánh giá!');
    }
    
    /**
     * Update the specified comment's approval status.
     * (Dành cho admin)
     */
    public function approve($id)
    {
        // Kiểm tra quyền admin
        if (!Auth::user()->isAdmin()) {
            return abort(403);
        }
        
        $comment = Comment::findOrFail($id);
        $comment->is_approved = true;
        $comment->save();
        
        return back()->with('success', 'Bình luận đã được phê duyệt.');
    }
    
    /**
     * Remove the specified comment from storage.
     * (Dành cho admin hoặc user đã tạo bình luận)
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Kiểm tra quyền xóa (là admin hoặc người tạo bình luận)
        if (Auth::user()->isAdmin() || (Auth::check() && Auth::id() === $comment->user_id)) {
            $comment->delete();
            return back()->with('success', 'Bình luận đã bị xóa.');
        }
        
        return abort(403);
    }
}