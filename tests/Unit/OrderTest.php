<?php
// tests/Unit/OrderTest.php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
{
    public function test_total_pesanan_dihitung_benar(): void
    {
        $order = new Order();
        $order->subtotal  = 150000; // 2 produk UMKM
        $order->ongkir    = 15000;
        $order->diskon    = 10000;

        $total = $order->hitungTotal();

        $this->assertEquals(155000, $total);
    }

    public function test_harga_produk_tidak_boleh_nol(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        validasiHarga(0);
    }
}