<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SALZA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
    @yield('styles')
</head>
<body class="min-h-screen bg-slate-900 text-white font-sans flex">

    @include('components.pelanggan-sidebar')

    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        @include('components.pelanggan-navbar')

        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
