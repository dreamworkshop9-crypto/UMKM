<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pesanan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="flex h-screen bg-gray-100">

    <!-- SIDEBAR -->
    <div class="w-64 bg-gradient-to-b from-indigo-500 to-purple-600 text-white p-5">
<a href="{{ route('brands.index') }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all
          {{ request()->routeIs('brands.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
    <i class="fa-solid fa-tags w-5 text-center {{ request()->routeIs('brands.*') ? 'text-emerald-500' : 'text-gray-400' }}"></i>
    Data Merek
</a>@include('dashboard.admin.widget.sidebar')
    </div>

    <!-- MAIN -->
    <div class="flex-1 p-6">

        <!-- NAVBAR -->
        <div class="bg-white p-4 rounded-xl shadow mb-5 flex justify-between">
            <h3 class="text-lg font-semibold">Data Pesanan</h3>
            <button class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
                + Tambah Pesanan
            </button>
        </div>

        <!-- TABLE -->
        <div class="bg-white p-4 rounded-xl shadow">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="border-b">
                        <th class="py-2">No</th>
                        <th class="py-2">Nama Pelanggan</th>
                        <th class="py-2">Produk</th>
                        <th class="py-2">Total</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">1</td>
                        <td>Andi</td>
                        <td>Kopi Arabika</td>
                        <td>Rp 50.000</td>
                        <td>
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-sm">
                                Pending
                            </span>
                        </td>
                        <td>
                            <button class="text-blue-500">Edit</button>
                            <button class="text-red-500 ml-2">Hapus</button>
                        </td>
                    </tr>

                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">2</td>
                        <td>Budi</td>
                        <td>Teh Hijau</td>
                        <td>Rp 30.000</td>
                        <td>
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-sm">
                                Selesai
                            </span>
                        </td>
                        <td>
                            <button class="text-blue-500">Edit</button>
                            <button class="text-red-500 ml-2">Hapus</button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

    @include('dashboard.admin.js.script')

</body>
</html>