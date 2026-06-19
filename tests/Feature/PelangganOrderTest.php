<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelangganOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_items_can_load_product_relation(): void
    {
        $pelanggan = User::factory()->create(['role' => 'pelanggan']);
        $product = Product::factory()->create();

        $order = Order::create([
            'user_id' => $pelanggan->id,
            'invoice' => 'INV-TEST-002',
            'customer_name' => $pelanggan->name,
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jl. Contoh No. 1',
            'total' => 150000,
            'payment_method' => 'cod',
            'status' => 'menunggu_konfirmasi',
            'notes' => null,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        $orders = Order::where('user_id', $pelanggan->id)
            ->with('items.product')
            ->get();

        $this->assertNotNull($orders->first()->items->first()->product);
        $this->assertSame($product->id, $orders->first()->items->first()->product->id);
    }

    public function test_pelanggan_dapat_melihat_daftar_pesanan_real(): void
    {
        $pelanggan = User::factory()->create(['role' => 'pelanggan']);

        Order::create([
            'user_id' => $pelanggan->id,
            'invoice' => 'INV-TEST-001',
            'customer_name' => $pelanggan->name,
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jl. Contoh No. 1',
            'total' => 150000,
            'payment_method' => 'cod',
            'status' => 'menunggu_konfirmasi',
            'notes' => null,
        ]);

        $response = $this->actingAs($pelanggan)->get('/pelanggan/pesanan');

        $response->assertOk();
        $response->assertSee('INV-TEST-001');
        $response->assertSee('Rp 150.000');

        $product = Product::factory()->create(['name' => 'Sepatu Test']);
        $order = Order::create([
            'user_id' => $pelanggan->id,
            'invoice' => 'INV-TEST-003',
            'customer_name' => $pelanggan->name,
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jl. Contoh No. 1',
            'total' => 150000,
            'payment_method' => 'cod',
            'status' => 'menunggu_konfirmasi',
            'notes' => null,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price,
        ]);

        $response = $this->actingAs($pelanggan)->get('/pelanggan/pesanan');

        $response->assertSee('Sepatu Test');
    }
}
