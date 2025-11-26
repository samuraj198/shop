<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!app()->environment('local', 'testing')) {
            $this->command->info('Сиды запускаются только в local/testing среде');
            return;
        }

        if (!CartItem::where('user_id', 1)->where('product_id', 2)->exists()) {
            CartItem::create([
                'user_id' => 1,
                'product_id' => 2,
            ]);
        }
        if (!CartItem::where('user_id', 3)->where('product_id', 2)->exists()) {
            CartItem::create([
                'user_id' => 3,
                'product_id' => 2,
            ]);
        }
    }
}
