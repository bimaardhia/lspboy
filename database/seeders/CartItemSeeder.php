<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CartItem;
use App\Models\Item;

class CartItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = Item::take(3)->get();

        foreach ($items as $item) {
            CartItem::create([
                'item_id' => $item->id,
                'quantity' => 2,
            ]);
        }
    }
}