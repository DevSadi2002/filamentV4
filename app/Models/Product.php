<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    //
    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'image',
        'description',
        'price',
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale',
    ];

    protected $casts = [
        'image' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'in_stock' => 'integer',
        'on_sale' => 'boolean',
    ];

    // Relationships with Category and Brand
    public function category(): BelongsTo
    {
        return $this->belongsTo(related: Category::class);
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(related: Brand::class);
    }

    // has many ordersItme
    public function orderItems(): HasMany
    {
        return $this->hasMany(related: OrderItem::class);
    }
}
