<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::all();

        foreach ($orders as $order) {
            $items = $products->random(2);
            foreach ($items as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price,
                ]);
            }
        }
    }
}

