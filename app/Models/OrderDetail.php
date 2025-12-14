<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara mass assignment
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relasi ke tabel orders
    public function order()
    {
        // setiap detail milik satu order
        return $this->belongsTo(Order::class);
    }

    // Relasi ke tabel products
    public function product()
    {
        // setiap detail milik satu produk
        return $this->belongsTo(Product::class);
    }
}
