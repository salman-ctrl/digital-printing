<?php
include 'vendor/autoload.php';
$pdo = new PDO('mysql:host=127.0.0.1;dbname=digital-printing', 'root', '');

// Update Spec 20 (China)
$pdo->exec("UPDATE product_specifications SET harga=15000, kualitas_warna=3, daya_tahan=3, tekstur_bahan=2, ukuran_cetak=5 WHERE id=20");

// Update Spec 21 (Korea)
$pdo->exec("UPDATE product_specifications SET harga=35000, kualitas_warna=4, daya_tahan=5, tekstur_bahan=4, ukuran_cetak=5 WHERE id=21");

// Update Spec 22 (Albatros)
$pdo->exec("UPDATE product_specifications SET harga=45000, kualitas_warna=5, daya_tahan=3, tekstur_bahan=5, ukuran_cetak=4 WHERE id=22");

echo "Data updated successfully with varied values.\n";
?>