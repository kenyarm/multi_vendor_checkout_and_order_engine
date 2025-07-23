<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'vendor_id',
        'price',
        'stock',
        'description',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeByVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    public function scopeUnderPrice($query, $maxPrice)
    {
        return $query->where('price', '<=', $maxPrice);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
