<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $html = view('pages.shop', [
        'products' => App\Models\Product::paginate(1),
        'categories' => App\Models\Category::all(),
        'brands' => App\Models\Brand::all()
    ])->render();
    echo "SUCCESS\n";
} catch (\Throwable $e) {
    echo "ERROR:\n";
    echo $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
