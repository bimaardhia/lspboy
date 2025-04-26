<?php

namespace Database\Seeders;


use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Item;
use Illuminate\Database\Seeder;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $items = Item::all(); // Ambil semua item dari database

        // Filter item yang punya nama
        $validItems = $items->filter(fn($item) => !empty($item->item_name))->values();

        if ($validItems->isEmpty()) {
            // Tidak ada item valid, keluar dari seeder
            info('TransactionSeeder: Tidak ada item dengan nama, seeder dilewati.');
            return;
        }

        $user = User::inRandomOrder()->first(); // Ambil 1 user secara acak

        Transaction::factory()->count(50)->create(['user_id' => $user->id])->each(function ($transaction) use ($validItems) {
            $total = 0;

            // Ambil 1–5 item acak dari item valid
            $itemsToBuy = $validItems->random(rand(1, min(5, $validItems->count())));

            foreach ($itemsToBuy as $item) {
                $qty = rand(1, 5);
                $subtotal = $item->price * $qty;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'item_id'        => $item->id,
                    'item_name'      => $item->item_name, 
                    'quantity'       => $qty,
                    'price'          => $item->price,
                    'subtotal'       => $subtotal,
                    'created_at'     => $transaction->created_at,
                    'updated_at'     => $transaction->updated_at,
                ]);

                $total += $subtotal;
            }

            // Update transaksi dengan total dan pembayaran
            $paid_amount = $total + rand(0, 10000);
            $transaction->update([
                'total'       => $total,
                'paid_amount' => $paid_amount,
                'change'      => $paid_amount - $total,
            ]);
        });
    }

}