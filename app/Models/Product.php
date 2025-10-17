<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'type', // Thêm cột type vào fillable
    ];
    public function mainImage()
    {
        return $this->hasOne(\App\Models\ProductImage::class)->where('is_main', true);
    }

    // Quan hệ lấy tất cả ảnh
    public function images()
    {
        return $this->hasMany(\App\Models\ProductImage::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->orderBy('created_at', 'desc');
    }
}