<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'guest_name',
        'content',
        'rating',
        'is_approved',  
        'is_rejected',  
    ];

    /**
     * Các thuộc tính nên được cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'is_rejected' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Các giá trị mặc định cho các thuộc tính.
     *
     * @var array
     */
    protected $attributes = [
        'is_approved' => false,
        'is_rejected' => false,
    ];

    /**
     * Mối quan hệ với Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Mối quan hệ với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy tên người bình luận (người dùng đã đăng nhập hoặc khách)
     *
     *@return string
     */
    public function getCommentatorNameAttribute()
    {
        return $this->user ? $this->user->name : $this->guest_name ?? 'Khách';
    }

    /**
     * Scope để lọc các bình luận đang chờ duyệt
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false)->where('is_rejected', false);
    }

    /**
     * Scope để lọc các bình luận đã được duyệt
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope để lọc các bình luận đã bị từ chối
     */
    public function scopeRejected($query)
    {
        return $query->where('is_rejected', true);
    }

    /**
     * Kiểm tra bình luận có đang chờ duyệt không
     */
    public function isPending()
    {
        return !$this->is_approved && !$this->is_rejected;
    }
}