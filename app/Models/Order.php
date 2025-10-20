<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'notes',
        'payment_method',
        'total',
        'status',
        'confirmed_at',
        'completed_at',
    ];
    
    protected $casts = [
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Trả về chuỗi trạng thái tiếng Việt
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending'    => ['Chờ xác nhận', 'bg-warning text-dark'],
            'processing' => ['Đã xác nhận', 'bg-info text-dark'],
            'shipping'   => ['Đang giao hàng', 'bg-primary text-white'],
            'completed'  => ['Đã hoàn thành', 'bg-success text-white'],
            'cancelled'  => ['Đã hủy', 'bg-danger text-white'],
            default      => ['Không xác định', 'bg-secondary text-white'],
        };
    }
}
