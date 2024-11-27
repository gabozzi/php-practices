<?php
session_start();

if (isset($_GET['name'], $_GET['price'], $_GET['image'], $_GET['size'], $_GET['quantity'])) {
    $product_name = $_GET['name'];
    $product_price = $_GET['price'];
    $product_image = $_GET['image'];
    $product_size = $_GET['size'];
    $product_quantity = $_GET['quantity'];

    // Process the data (add to cart, etc.)
    // For example, store the product in the session cart
    $cart_item = [
        'name' => $product_name,
        'price' => $product_price,
        'image' => $product_image,
        'size' => $product_size,
        'quantity' => $product_quantity,
        'total' => $product_price * $product_quantity
    ];

    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'][] = $cart_item;
    } else {
        $_SESSION['cart'] = [$cart_item];
    }

    // Optionally, redirect to cart.php or another page
    header("Location: cart.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Confirmation</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome for shopping cart icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .header-icon {
            font-size: 40px;
            margin-right: 10px;
        }

        .message-container {
            text-align: center;
            margin-top: 50px;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-container a {
            margin: 0 10px;
        }
    </style>
</head>

<body>

    <header class="text-dark py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Market Icon and Title -->
            <div class="d-flex align-items-center">
                <i class="bi bi-shop-window header-icon"></i>
                <h1 class="m-0">Learn IT Easy Online Shop</h1>
            </div>

            <!-- Cart Button with Badge -->
            <div class="cart-button">
                <!-- Bootstrap Cart Button -->
                <a href="cart.php" class="btn btn-outline-primary position-relative">
                    <i class="fas fa-shopping-cart"></i> Cart
                    <!-- Cart Count Badge -->
                    <span class="badge badge-pill badge-danger position-absolute" style="top: -5px; right: -10px;">
                        <?php 
                        // Count total items in the cart
                        $cart_items = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                        echo $cart_items;
                        ?>
                    </span>
                </a>
            </div>

        </div>
    </header>

    <hr>

    <div class="message-container">
        <h2>Product Successfully Added to the Cart</h2>
        <p>What would you like to do next?</p>

        <div class="btn-container">
            <a href="cart.php" class="btn btn-primary">View Cart</a>
            <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>

    <!-- Bootstrap JS and Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
