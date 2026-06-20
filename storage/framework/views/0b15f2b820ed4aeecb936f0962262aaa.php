<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SALZA'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { 'dashboard-card': '#1e293b' }
                }
            }
        }
    </script>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body class="min-h-screen bg-slate-900 text-white font-sans flex">

    <?php echo $__env->make('components.pelanggan-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(session('success')): ?>
    <div class="fixed top-4 right-4 z-50 bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 px-4 py-3 rounded-xl text-sm backdrop-blur-sm" id="flash-success">
        <i class="fa fa-check-circle mr-1"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="fixed top-4 right-4 z-50 bg-red-500/20 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl text-sm backdrop-blur-sm" id="flash-error">
        <i class="fa fa-exclamation-circle mr-1"></i> <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        <?php echo $__env->make('components.pelanggan-navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <main class="flex-1 p-8">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script>
    setTimeout(()=>{
        document.querySelectorAll('[id^="flash-"]').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/irawan/laravel/shoesmarket/UMKMmm/UMKM/resources/views/layouts/pelanggan.blade.php ENDPATH**/ ?>