<h2 class="text-2xl font-bold mb-6">MyApp</h2>

<a href="#" class="block py-2 px-3 rounded hover:bg-white/20">🏠 Dashboard</a>

<!-- PRODUK -->
<div>
    <div onclick="toggleMenu('produkMenu')" 
         class="cursor-pointer py-2 px-3 rounded hover:bg-white/20">
        📦 Produk
    </div>

    <div id="produkMenu" class="hidden ml-4 mt-1 space-y-1">
        <a href="#" class="block py-1 hover:underline">Kategori</a>
        <a href="#" class="block py-1 hover:underline">List Barang</a>
    </div>
</div>
<div>
    <div onclick="toggleMenu('merekMenu')" 
         class="cursor-pointer py-2 px-3 rounded hover:bg-white/20">
        Merek
    </div>

    <div id="merekMenu" class="hidden ml-4 mt-1 space-y-1">
        <a href="#" class="block py-1 hover:underline">hp</a>
        <a href="#" class="block py-1 hover:underline">laptop</a>
    </div>
</div>

<a href="../pesanan/index.blade.php" class="block py-2 px-3 rounded hover:bg-white/20">🛒 Pesanan</a>
<a href="" class="block py-2 px-3 rounded hover:bg-white/20">👤 Pelanggan</a>
<a href="/logout" class="block py-2 px-3 rounded hover:bg-red-400">🚪 Logout</a>