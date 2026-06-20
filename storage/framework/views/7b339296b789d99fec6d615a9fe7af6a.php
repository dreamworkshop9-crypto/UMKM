<?php $__env->startSection('title', 'Pesanan Saya - SALZA'); ?>
<?php $__env->startSection('page-title', 'Pesanan Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-dashboard-card rounded-xl border border-slate-700/30 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-white">Daftar Pesanan</h2>
        <div class="flex gap-2">
            <select class="bg-slate-800 border border-slate-700 text-slate-300 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block p-2">
                <option>Semua Status</option>
                <option>Menunggu Pembayaran</option>
                <option>Diproses</option>
                <option>Dikirim</option>
                <option>Selesai</option>
            </select>
        </div>
    </div>

    <?php if($orders->isNotEmpty()): ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="rounded-2xl border border-slate-700/40 bg-slate-800/40 p-5">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-emerald-400"><?php echo e($order->invoice); ?></p>
                            <h3 class="text-lg font-semibold text-white mt-1"><?php echo e($order->created_at->translatedFormat('d F Y, H:i')); ?></h3>
                            <p class="text-sm text-slate-400">Total: Rp <?php echo e(number_format($order->total ?? 0, 0, ',', '.')); ?></p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-300 text-xs font-semibold uppercase tracking-wide"><?php echo e(str_replace('_', ' ', $order->status)); ?></span>
                            <a href="<?php echo e(route('order.show', $order->invoice)); ?>" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium">Detail</a>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <?php $__currentLoopData = $order->items->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="px-3 py-1 rounded-full bg-slate-700/70 text-slate-200 text-xs"><?php echo e($item->product->name ?? $item->produk->name ?? 'Produk'); ?> × <?php echo e($item->quantity); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center py-16">
            <i class="fa fa-shopping-cart text-5xl text-slate-600 mb-4"></i>
            <h3 class="text-lg font-medium text-slate-300">Belum Ada Pesanan</h3>
            <p class="text-slate-500 text-sm mt-1 text-center max-w-sm">Anda belum melakukan pesanan apapun. Ayo mulai belanja dan temukan sepatu impian Anda.</p>
            <a href="<?php echo e(route('shop')); ?>" class="mt-6 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20">Mulai Belanja</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pelanggan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKMmm/UMKM/resources/views/pelanggan/pesanan.blade.php ENDPATH**/ ?>