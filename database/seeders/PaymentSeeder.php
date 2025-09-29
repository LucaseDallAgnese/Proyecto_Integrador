<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total ?? 100,
                'method' => 'tarjeta',
            ]);
        }
    }
}
