<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'count',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
