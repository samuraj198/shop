<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'img',
        'description',
        'price',
        'discount',
        'category_id',
        'specifications'
    ];

    protected $casts = [
        'specifications' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
