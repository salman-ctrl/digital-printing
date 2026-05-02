<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$specs = \App\Models\ProductSpecification::all();
foreach($specs as $s) {
    echo "ID: {$s->id}, HW: {$s->harga}, KW: {$s->kualitas_warna}, DT: {$s->daya_tahan}, TB: {$s->tekstur_bahan}, UC: {$s->ukuran_cetak}\n";
}
