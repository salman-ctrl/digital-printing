<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProductSpecification;

$specs = ProductSpecification::all();
foreach($specs as $s) {
    // Memberikan nilai yang lebih bervariasi
    $s->kualitas_warna = rand(2, 5);
    $s->daya_tahan = rand(2, 5);
    $s->tekstur_bahan = rand(2, 5);
    $s->ukuran_cetak = rand(1, 5);
    $s->save();
}

echo "Data spesifikasi berhasil diperbarui dengan nilai bervariasi.\n";
