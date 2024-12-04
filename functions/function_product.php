<?php
require_once 'database/database.php';

// Fungsi untuk mengambil semua barang berdasarkan kategori
function getAllProducts($kategori = null) {
    $conn = getConnection();
    $query = "SELECT * FROM barang";
    
    if ($kategori) {
        $query .= " WHERE kategori = :kategori";
    }

    $stmt = $conn->prepare($query);

    if ($kategori) {
        $stmt->bindParam(':kategori', $kategori);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk mengambil data barang berdasarkan ID
function getProductById($idbarang) {
    $conn = getConnection();
    $query = "SELECT * FROM barang WHERE idbarang = :idbarang";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idbarang', $idbarang);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fungsi untuk mengambil kategori produk yang ada
function getCategories() {
    $conn = getConnection();
    $query = "SELECT DISTINCT kategori FROM barang";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
