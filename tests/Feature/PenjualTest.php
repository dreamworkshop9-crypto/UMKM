<?php
// tests/Feature/PenjualTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class PenjualTest extends TestCase
{
    use RefreshDatabase;

    public function test_penjual_umkm_bisa_registrasi(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Batik Nusantara',
            'email'                 => 'batik@umkm.id',
            'password'              => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'role'                  => 'penjual',
        ]);

        $response->assertRedirect('/toko/setup');
        $this->assertDatabaseHas('users', ['email' => 'batik@umkm.id']);
    }

    public function test_penjual_bisa_upload_produk(): void
    {
        $penjual = User::factory()->create(['role' => 'penjual']);

        $response = $this->actingAs($penjual)->post('/produk', [
            'nama'     => 'Batik Parang Klasik',
            'harga'    => 250000,
            'stok'     => 30,
            'kategori' => 'fashion',
            'deskripsi'=> 'Batik tulis asli Jogja',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'nama'  => 'Batik Parang Klasik',
            'harga' => 250000,
        ]);
    }

    public function test_halaman_admin_toko_diproteksi(): void
    {
        $response = $this->get('/toko/dashboard');
        $response->assertRedirect('/login');
    }
}