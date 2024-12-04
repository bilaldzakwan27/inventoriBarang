<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko ATK Bilal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #7001FE;
            --primary-light: #8f34fe;
            --primary-dark: #5801cc;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        .cart-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .cart-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0e6fe;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            margin-bottom: 1rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .cart-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(112, 1, 254, 0.1);
        }

        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 1.5rem;
        }

        .cart-item-details {
            flex-grow: 1;
        }

        .cart-item-details h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .cart-item-details p {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .quantity-input {
            width: 80px;
            padding: 0.5rem;
            border: 2px solid #f0e6fe;
            border-radius: 5px;
            text-align: center;
            margin: 0.5rem 0;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .total-section {
            background-color: #f0e6fe;
            padding: 1.5rem;
            border-radius: 10px;
            margin-top: 2rem;
        }

        .total-price {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .checkout-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1rem;
            width: 100%;
        }

        .checkout-btn:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }

        .empty-cart {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        footer {
            background-color: var(--primary-dark);
            padding: 2rem 0;
            margin-top: auto;
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }

        .modal-body {
            text-align: center;
        }

        .modal-body img {
            max-width: 200px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .cart-item-img {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-store me-2"></i>Toko ATK Bilal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Produk
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Content -->
    <div class="container mt-5">
        <div class="cart-container">
            <h3 class="cart-title">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </h3>
            <div id="cartItems"></div>
            <div class="total-section">
                <h4 class="total-price" id="totalPrice"></h4>
                <button class="checkout-btn" onclick="checkout()">
                    <i class="fas fa-cash-register me-2"></i>Proses Pembayaran
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">
                        <i class="fas fa-cash-register me-2"></i>Proses Pembayaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="https://cdn-icons-png.flaticon.com/512/4290/4290854.png" alt="Checkout Illustration" class="img-fluid">
                    <h4>Siap Melakukan Pembayaran?</h4>
                    <p class="text-muted">
                        Anda telah menyelesaikan belanja. Silakan menuju ke kasir untuk melakukan pembayaran.
                    </p>
                    <button type="button" class="btn w-100" style="background-color: #7001FE; color: white;" onclick="closeModal()">
                        Menuju Kasir
                    </button>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function displayCart() {
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
            let cartContainer = document.getElementById('cartItems');
            cartContainer.innerHTML = '';

            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart fa-3x mb-3" style="color: #7001FE"></i>
                        <h4>Keranjang Belanja Kosong</h4>
                        <p>Silakan tambahkan produk ke keranjang</p>
                    </div>
                `;
                document.getElementById('totalPrice').innerText = `Total: Rp 0`;
                return;
            }

            cart.forEach(product => {
                const productCard = `
                    <div class="cart-item">
                        <img src="${product.image}" alt="${product.name}" class="cart-item-img">
                        <div class="cart-item-details">
                            <h5>${product.name}</h5>
                            <p>Rp ${product.price.toLocaleString()}</p>
                            <input type="number" 
                                   value="${product.quantity}" 
                                   min="1" 
                                   max="99"
                                   class="quantity-input"
                                   onchange="updateQuantity(${product.id}, this.value)">
                            <p class="mt-2">Total: Rp ${(product.price * product.quantity).toLocaleString()}</p>
                            <button class="btn text-danger" onclick="removeItem(${product.id})">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;
                cartContainer.innerHTML += productCard;
            });

            const totalPrice = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            document.getElementById('totalPrice').innerText = `Total: Rp ${totalPrice.toLocaleString()}`;
        }

        function updateQuantity(id, quantity) {
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
            const productIndex = cart.findIndex(item => item.id === id);

            if (productIndex !== -1) {
                cart[productIndex].quantity = parseInt(quantity);
                sessionStorage.setItem('cart', JSON.stringify(cart));
                displayCart();
            }
        }

        function removeItem(id) {
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
            cart = cart.filter(item => item.id !== id);
            sessionStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        }

        function checkout() {
            let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

            if (cart.length === 0) {
                alert('Keranjang Anda kosong!');
                return;
            }

            // Show checkout modal
            var checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
            checkoutModal.show();
        }

        function closeModal() {
            // Close the checkout modal
            var checkoutModal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
            checkoutModal.hide();
        }

        window.onload = displayCart;
    </script>
</body>

</html>