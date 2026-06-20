<?php $__env->startSection('title', ($title ?? 'Halaman') . ' - SALZA'); ?>
<?php $__env->startSection('page-title', $title ?? 'Halaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 p-16 text-center">
    <div class="w-16 h-16 rounded-2xl bg-slate-700/50 flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-hammer text-2xl text-slate-500"></i>
    </div>
    <h3 class="text-lg font-bold text-white mb-1"><?php echo e($title); ?></h3>
    <p class="text-sm text-slate-400">Halaman ini masih dalam pengembangan.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/irawan/laravel/shoesmarket/UMKMmm/UMKM/resources/views/pages/placeholder.blade.php ENDPATH**/ ?>