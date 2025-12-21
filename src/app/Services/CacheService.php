<?php

namespace App\Services;


use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function getCachedCategories()
    {
        $categories = Cache::remember('categories', 3600, function () {
            return Category::orderBy('count', 'desc')->get();
        });

        return $categories;
    }

    public function clearCachedCategories(): void
    {
        Cache::forget('categories');
    }


}
