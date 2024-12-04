<?php
require_once 'functions/function_product.php';

// Ambil ID produk
$idbarang = isset($_GET['idbarang']) ? $_GET['idbarang'] : null;

if ($idbarang) {
    $produk = getProductById($idbarang);
} else {
    echo "Produk tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - <?= htmlspecialchars($produk['namabarang']) ?></title>
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

        .product-image {
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.02);
        }

        .product-details {
            background-color: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .product-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .category-badge {
            background-color: #f0e6fe;
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .stock-info {
            background-color: #e8f4fe;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .tutorial-box {
            background-color: #fff;
            border-left: 5px solid var(--primary-color);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .tutorial-box h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .tutorial-box ol {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }

        .tutorial-box li {
            margin-bottom: 0.8rem;
            color: #555;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #f0e6fe;
            border: none;
            color: var(--primary-color);
            padding: 0.8rem 2rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #e2d1fd;
            transform: translateY(-2px);
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

    <!-- Detail Produk -->
    <div class="container mt-5">
        <div class="row g-4">
            <div class="col-md-6">
                <img src="data:image/jpeg;base64,<?= base64_encode($produk['gambar']) ?>"
                    class="img-fluid product-image"
                    alt="<?= htmlspecialchars($produk['namabarang']) ?>">
            </div>
            <div class="col-md-6">
                <div class="product-details">
                    <span class="category-badge">
                        <i class="fas fa-tag me-1"></i> <?= htmlspecialchars($produk['kategori']) ?>
                    </span>
                    <h2 class="product-title"><?= htmlspecialchars($produk['namabarang']) ?></h2>
                    <div class="price">
                        Rp <?= number_format($produk['hargajual'], 0, ',', '.') ?>
                    </div>
                    <div class="stock-info">
                        <i class="fas fa-box me-1"></i> Stok: <?= $produk['stok'] ?> item
                    </div>

                    <!-- Input Quantity -->
                    <div class="quantity-section mt-3">
                        <label for="quantity" class="form-label">Jumlah</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="<?= $produk['stok'] ?>" value="1" />
                    </div>

                    <div class="d-grid gap-2 d-md-flex mt-4">
                        <button onclick="addToCart(<?= $produk['idbarang'] ?>, '<?= htmlspecialchars($produk['namabarang']) ?>', <?= $produk['hargajual'] ?>, 'data:image/jpeg;base64,<?= base64_encode($produk['gambar']) ?>')" class="btn btn-primary">
                            <i class="fas fa-cart-plus me-1"></i> Tambahkan ke Keranjang
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Produk
                        </a>
                    </div>
                     <!-- Notification Area -->
                     <div id="notification" class="mt-3"></div>

                    <div class="tutorial-box">
                    <h4><i class="fas fa-info-circle me-2"></i>Cara Pembelian</h4>
                    <ol>
                        <li>Tambahkan produk ini ke keranjang dengan mengklik tombol "Tambahkan ke Keranjang"</li>
                        <li>Untuk menambah produk lain, klik "Kembali ke Produk" dan pilih produk yang diinginkan</li>
                        <li>Setelah selesai, klik menu "Keranjang" dan tunjukan item belanja ke kasir untuk melakukan pembayaran</li>
                    </ol>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="text-white mb-0">&copy; 2024 Toko ATK Bilal. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk menambah produk ke keranjang -->
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