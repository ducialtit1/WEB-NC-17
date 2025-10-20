<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Hiển thị danh sách bình luận
     */
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'product'])->orderBy('created_at', 'desc');

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'pending') {
                $query->where('is_approved', false)->where('is_rejected', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'rejected') {
                $query->where('is_rejected', true);
            }
        }

        $comments = $query->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Phê duyệt bình luận
     */
    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = true;
        $comment->is_rejected = false;
        $comment->save();

        return back()->with('success', '✅ Bình luận đã được phê duyệt.');
    }

    /**
     * Từ chối bình luận
     */
    public function reject($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = false;
        $comment->is_rejected = true;
        $comment->save();

        return back()->with('success', '🚫 Bình luận đã bị từ chối.');
    }

    /**
     * Xóa bình luận
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', '🗑️ Bình luận đã bị xóa.');
    }

    /**
     * Sửa bình luận (tuỳ chọn)
     */
    public function edit($id)
    {
        $comment = Comment::with(['user', 'product'])->findOrFail($id);
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($validated);

        return redirect()->route('admin.comments.index')->with('success', '✅ Bình luận đã được cập nhật.');
    }
}
