<?php $__env->startSection('title', 'Buku Alamat - SALZA'); ?>
<?php $__env->startSection('page-title', 'Buku Alamat'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-dashboard-card rounded-xl border border-slate-700/30 p-6">
    <div class="flex justify-between items-center mb-6 border-b border-slate-700/50 pb-4">
        <div>
            <h2 class="text-xl font-bold text-white">Daftar Alamat</h2>
            <p class="text-slate-400 text-sm mt-1">Kelola alamat pengiriman Anda.</p>
        </div>
        <button class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium rounded-lg shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-2">
            <i class="fa fa-plus"></i> Tambah Alamat
        </button>
    </div>

    <div class="flex flex-col items-center justify-center py-16">
        <i class="fa fa-map-marker-alt text-5xl text-slate-600 mb-4"></i>
        <h3 class="text-lg font-medium text-slate-300">Belum ada alamat</h3>
        <p class="text-slate-500 text-sm mt-1 text-center max-w-sm">Anda belum menambahkan alamat pengiriman. Tambahkan sekarang untuk mempermudah proses checkout.</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pelanggan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKMmm/UMKM/resources/views/pelanggan/alamat.blade.php ENDPATH**/ ?>