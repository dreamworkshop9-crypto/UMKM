<?php $__env->startSection('title', 'Ulasan Saya - SALZA'); ?>
<?php $__env->startSection('page-title', 'Ulasan Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-dashboard-card rounded-xl border border-slate-700/30 p-6">
    <div class="mb-6 border-b border-slate-700/50 pb-4">
        <h2 class="text-xl font-bold text-white">Ulasan Produk</h2>
        <p class="text-slate-400 text-sm mt-1">Berikan penilaian untuk produk yang telah Anda beli.</p>
    </div>

    <div class="flex flex-col items-center justify-center py-16">
        <i class="fa fa-star-half-alt text-5xl text-slate-600 mb-4"></i>
        <h3 class="text-lg font-medium text-slate-300">Tidak ada ulasan tertunda</h3>
        <p class="text-slate-500 text-sm mt-1 text-center max-w-sm">Semua pesanan yang telah selesai sudah Anda beri ulasan, atau Anda belum melakukan pesanan.</p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pelanggan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKMmm/UMKM/resources/views/pelanggan/ulasan.blade.php ENDPATH**/ ?>