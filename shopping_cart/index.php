<?php
// Start the session to manage cart
session_start();

// Sample product data (replace with your dynamic content)
$products = [
    ['id' => 1, 'name' => 'Plain Beige Shirt', 'price' => 19.99, 'image' => 'images/beige1.avif', 'hover_image' => 'images/beige2.avif'],
    ['id' => 2, 'name' => 'Plain Blue Shirt', 'price' => 29.99, 'image' => 'images/blue1.avif', 'hover_image' => 'images/blue2.avif'],
    ['id' => 3, 'name' => 'Plain Coral Shirt', 'price' => 39.99, 'image' => 'images/coral1.avif', 'hover_image' => 'images/coral2.avif'],
    ['id' => 4, 'name' => 'Plain Grey Shirt', 'price' => 49.99, 'image' => 'images/grey1.avif', 'hover_image' => 'images/grey2.avif'],
    ['id' => 5, 'name' => 'Plain Light Grey Shirt', 'price' => 59.99, 'image' => 'images/light_grey1.avif', 'hover_image' => 'images/light_grey2.avif'],
    ['id' => 6, 'name' => 'Plain Pink Shirt', 'price' => 69.99, 'image' => 'images/pink1.avif', 'hover_image' => 'images/pink2.avif'],
    ['id' => 7, 'name' => 'Rick & Morty Shirt', 'price' => 79.99, 'image' => 'images/rick1.avif', 'hover_image' => 'images/rick2.avif'],
    ['id' => 8, 'name' => 'Plain White Shirt', 'price' => 89.99, 'image' => 'images/white1.avif', 'hover_image' => 'images/white2.avif'],
];

// Handling cart addition (for example purposes, this can be triggered from a button in the product card)
if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];

    // Check if the product already exists in the cart
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1; // Add product with quantity 1
    } else {
        $_SESSION['cart'][$product_id] += 1; // Increment quantity
    }

    header("Location: index.php"); // Redirect back to index to avoid re-posting
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn IT Easy Online Shop</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
    /* .cart-button {
        display: flex;
        align-items: center;
    }

    .cart-button .btn {
        display: flex;
        align-items: center;
    }

    .cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        font-size: 12px;
        border-radius: 50%;
        padding: 5px;
        width: 20px;
        height: 20px;
        text-align: center;
    } */

    .header-icon {
        font-size: 40px;
        margin-right: 10px;
    }

    /* Hover effect for product cards */
    .card {
        position: relative;
        overflow: hidden;
        border: none;
        transition: all 0.3s ease;
    }

    /* Product image wrapper */
    .card-img-wrapper {
        position: relative;
        width: 100%;
        height: 400px;
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s ease;
    }

    /* Initially hide the hover image */
    .hover-image {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    /* Hover effect to change image */
    .card:hover .main-image {
        opacity: 0;
    }

    .card:hover .hover-image {
        opacity: 1;
    }

    /* Initially hide the Add to Cart button */
    .add-to-cart-btn {
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        transition: all 0.3s ease;
    }

    /* Show the Add to Cart button when hovered */
    .card:hover .add-to-cart-btn {
        bottom: 10px;
    }

    .add-to-cart-btn a {
        padding: 10px 20px;
        font-size: 14px;
    }

    /* Styling the card on hover */
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        text-align: center;
    }

    .cart-button {
        display: flex;
        align-items: center;
    }

    .cart-button i {
        margin-right: 10px;
    }

    .cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: red;
        color: white;
        font-size: 12px;
        border-radius: 50%;
        padding: 5px;
        width: 20px;
        height: 20px;
        text-align: center;
    }

    .btn-container {
        display: flex;
        justify-content: space-between;
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

    <!-- Horizontal Line -->
    <hr>

    <!-- Product Cards Section -->
    <div class="container my-5">
        <div class="row">
            <?php
        foreach ($products as $product) {
        ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <!-- Product Image - Initially showing the first image -->
                    <div class="card-img-wrapper">
                        <img src="<?= $product['image']; ?>" class="card-img-top main-image"
                            alt="<?= $product['name']; ?>">
                        <img src="<?= $product['hover_image']; ?>" class="card-img-top hover-image"
                            alt="<?= $product['name']; ?>">
                        <!-- Add to Cart Button (Navigate to details.php with product info) -->
                        <div class="add-to-cart-btn">
                            <a href="details.php?name=<?= urlencode($product['name']); ?>&price=<?= $product['price']; ?>&image=<?= urlencode($product['image']); ?>&hover_image=<?= urlencode($product['hover_image']); ?>"
                                class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                    <!-- Product Name and Price -->
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $product['name']; ?></h5>
                        <p class="card-text">$<?= number_format($product['price'], 2); ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>


    <!-- Bootstrap JS and Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>