<?php
require_once '../functions/function_product.php';

// Ambil kategori yang dipilih dari query string
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

// Ambil daftar produk berdasarkan kategori
$produkList = getAllProducts($kategori);

// Jika ada pencarian, filter produk berdasarkan nama
if ($search) {
    $produkList = array_filter($produkList, function($produk) use ($search) {
        return stripos($produk['namabarang'], $search) !== false;
    });
}
?>
