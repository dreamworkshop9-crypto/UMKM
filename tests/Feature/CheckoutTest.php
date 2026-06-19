<?php
// tests/Feature/CheckoutTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{Cart, Product, User};

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_pembeli_berhasil_checkout(): void
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $produk  = Product::factory()->create(['stok' => 10, 'harga' => 75000]);

        $response = $this->actingAs($pembeli)->post('/checkout', [
            'produk_id' => $produk->id,
            'jumlah'    => 2,
            'alamat'    => 'Jl. Batam Center No. 1',
        ]);

        $response->assertRedirect('/pesanan/sukses');
        $this->assertDatabaseHas('orders', ['user_id' => $pembeli->id]);

        // Pastikan stok berkurang setelah checkout
        $this->assertDatabaseHas('products', [
            'id'   => $produk->id,
            'stok' => 8,
        ]);
    }

    public function test_checkout_gagal_jika_stok_habis(): void
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $produk  = Product::factory()->create(['stok' => 0]);

        $response = $this->actingAs($pembeli)->post('/checkout', [
            'produk_id' => $produk->id,
            'jumlah'    => 1,
        ]);

        $response->assertSessionHasErrors('stok');
        $this->assertDatabaseMissing('orders', ['user_id' => $pembeli->id]);
    }

    public function test_api_checkout_membuat_pesanan_dari_keranjang(): void
    {
        $pembeli = User::factory()->create(['role' => 'pembeli']);
        $produk  = Product::factory()->create(['stock' => 10, 'price' => 75000]);

        Cart::create([
            'user_id' => $pembeli->id,
            'product_id' => $produk->id,
            'quantity' => 2,
            'size' => null,
            'color' => null,
        ]);

        $response = $this->actingAs($pembeli)->postJson('/api/checkout', [
            'alamat' => 'Jl. Merdeka No. 1',
            'provinsi' => 'Jawa Barat',
            'kurir' => 'jne',
            'ongkir' => 15000,
            'pembayaran' => 'cod',
            'catatan' => 'Segera diproses',
            'coupon' => null,
            'total' => 165000,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['code'],
            ]);

        $this->assertDatabaseHas('orders', ['invoice' => $response->json('data.code')]);
        $this->assertDatabaseHas('order_items', ['product_id' => $produk->id, 'quantity' => 2]);
    }
}