<?php
require_once 'functions/function_product.php';
include_once 'database/database.php';

// Ambil kategori yang tersedia dari database
$categories = getCategories();

// Ambil kategori yang dipilih dan query pencarian
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;
$produkList = getAllProducts($kategori);

// Filter berdasarkan pencarian produk
if ($search) {
    $produkList = array_filter($produkList, function ($produk) use ($search) {
        return stripos($produk['namabarang'], $search) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Toko ATK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #7001FE;
            --primary-light: #8f34fe;
            --primary-dark: #5801cc;
        }

        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: var(--primary-color) !important;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(112, 1, 254, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #e0e0e0 !important;
            transform: translateY(-2px);
        }

        .search-section {
            background-color: white;
            padding: 2rem 0;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            border-radius: 0 0 20px 20px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e0e0;
            padding: 0.8rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(112, 1, 254, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(112, 1, 254, 0.1);
        }

        .card-img-top {
            transition: all 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .category-badge {
            background-color: #f0e6fe;
            color: var(--primary-color);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 0.8rem;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stock-info {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        footer {
            background-color: var(--primary-dark);
            padding: 2rem 0;
            margin-top: 5rem;
        }

        .social-links a {
            color: white;
            margin: 0 10px;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: var(--primary-light);
            transform: translateY(-3px);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-store me-2"></i>Toko ATK Bilal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart me-1"></i> Keranjang (<span id="cartCount">0</span>)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Filter dan Search Bar -->
    <div class="search-section">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6">
                    <form action="index.php" method="GET" class="d-flex">
                        <input type="text" class="form-control" placeholder="Cari Produk..." name="search" />
                        <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="col-md-3">
                    <form action="index.php" method="GET">
                        <select name="kategori" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['kategori'] ?>" <?= $kategori == $category['kategori'] ? 'selected' : '' ?>>
                                    <?= $category['kategori'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="container mt-5">
        <div class="row">
            <?php foreach ($produkList as $produk): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="data:image/jpeg;base64,<?= base64_encode($produk['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($produk['namabarang']) ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <span class="category-badge"><?= htmlspecialchars($produk['kategori']) ?></span>
                            <h5 class="card-title"><?= htmlspecialchars($produk['namabarang']) ?></h5>
                            <div class="price mb-2">Rp <?= number_format($produk['hargajual'], 0, ',', '.') ?></div>
                            <p class="stock-info"><i class="fas fa-box me-1"></i> Stok: <?= $produk['stok'] ?> pcs</p>
                            <a href="product_detail.php?idbarang=<?= $produk['idbarang'] ?>" class="btn btn-primary mt-auto">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0 text-white">&copy; 2024 Toko ATK Bilal. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addToCart(id, name, price, image) {
            const quantity = parseInt(document.getElementById('quantity').value); // Ambil jumlah dari input quantity
            if (quantity <= 0) {
                alert("Jumlah produk tidak valid.");
                return;
            }

            let cart = JSON.parse(sessionStorage.getItem('cart')) || []; // Ambil cart dari sessionStorage atau buat array kosong jika belum ada

            // Cek jika produk sudah ada dalam cart
            const existingProductIndex = cart.findIndex(item => item.id === id);
            if (existingProductIndex !== -1) {
                // Jika produk ada, update quantity
                cart[existingProductIndex].quantity += quantity;
            } else {
                // Jika produk belum ada, tambah produk baru
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    image: image,
                    quantity: quantity
                });
            }

            // Simpan cart kembali ke sessionStorage
            sessionStorage.setItem('cart', JSON.stringify(cart));

            // Mengupdate jumlah produk di navbar
            updateCartCount();

            // Tampilkan notifikasi bahwa produk berhasil ditambahkan ke keranjang
            showNotification("Produk berhasil ditambahkan ke keranjang!");
        }

        function updateCartCount() {
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
            const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('cartCount').innerText = cartCount;
        }

        function showNotification(message) {
            const notificationElement = document.getElementById('notification');
            notificationElement.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        }

        // Memperbarui cart count saat halaman dimuat
        window.onload = updateCartCount;
    </script>
</body>

</html>