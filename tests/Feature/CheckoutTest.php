<?php
// tests/Feature/CheckoutTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{User, Product};

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
}