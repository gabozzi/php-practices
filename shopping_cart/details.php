<?php
session_start();

function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// Check if the product details are passed via the URL
if (isset($_GET['name']) && isset($_GET['price']) && isset($_GET['image'])) {
    // Sanitize and validate inputs
    $product_name = sanitize_input($_GET['name']);
    $product_price = filter_var($_GET['price'], FILTER_VALIDATE_FLOAT);
    $product_image = sanitize_input($_GET['image']);
    $product_size = isset($_POST['size']) ? sanitize_input($_POST['size']) : ''; // Get size from form input
    $product_quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Get quantity from form input

    // Ensure product price is a valid number
    if ($product_price === false || $product_price <= 0) {
        $product_price = 0.00;  // Set to a default value if invalid
    }

    // Check if image exists (fallback image in case of failure)
    if (!file_exists($product_image)) {
        $product_image = "images/default.jpg";
    }
} else {
    // Default values in case of an error (no product selected)
    $product_name = "Product not found";
    $product_price = 0.00;
    $product_image = "images/default.jpg"; // Fallback image
    $product_size = ''; // Default size if not provided
    $product_quantity = 1; // Default quantity if not provided
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
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

    .product-details {
        display: flex;
        margin-top: 20px;
    }

    .product-details img {
        max-width: 400px;
        height: auto;
        margin-right: 20px;
    }

    .product-info {
        flex: 1;
    }

    .product-info h2 {
        font-size: 2rem;
    }

    .product-info p {
        font-size: 1.2rem;
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

    <hr>

    <!-- Product Details -->
    <div class="container product-details">
        <div>
            <!-- Product Image -->
            <img src="<?= $product_image; ?>" alt="<?= $product_name; ?>" />
        </div>
        <div class="product-info">
            <!-- Product Name and Price -->
            <h2><?= $product_name; ?></h2>
            <p>Price: $<?= number_format($product_price, 2); ?></p>

            <!-- Lorem Ipsum Product Description -->
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum.</p>

            <!-- Size Selection -->
            <p>Select Size:</p>
            <div>
                <label><input type="radio" name="size" value="small"> Small</label>
                <label><input type="radio" name="size" value="medium"> Medium</label>
                <label><input type="radio" name="size" value="large"> Large</label>
            </div>

            <!-- Quantity Selection -->
            <p>Quantity:</p>
            <input type="number" id="quantity" class="form-control" placeholder="0" min="1" max="100" />

            <!-- Confirm and Cancel Buttons -->
            <div class="btn-container mt-3">

                <a href="confirm.php?name=<?= urlencode($product_name); ?>&price=<?= $product_price; ?>&image=<?= urlencode($product_image); ?>&size=<?= urlencode($product_size); ?>&quantity=<?= $product_quantity; ?>"
                    class="btn btn-success" id="confirm-btn">Confirm Product Purchase</a>

                <a href="index.php" class="btn btn-danger">Cancel / Go Back</a>

            </div>

        </div>
    </div>

    <!-- Bootstrap JS and Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    // JavaScript to dynamically update the confirm button's link with size and quantity
    document.getElementById('confirm-btn').addEventListener('click', function(event) {
        var quantity = document.getElementById('quantity').value;
        var sizeSelected = document.querySelector('input[name="size"]:checked');

        if (!sizeSelected) {
            event.preventDefault(); // Prevent form submission
            alert("Please select a size.");
            return;
        }

        // Validate quantity
        if (quantity < 1 || quantity > 100 || isNaN(quantity)) {
            event.preventDefault(); // Prevent form submission
            alert("Please enter a valid quantity between 1 and 100.");
            return;
        }

        // Update the href of the confirm button
        var baseUrl =
            "confirm.php?name=<?= urlencode($product_name); ?>&price=<?= $product_price; ?>&image=<?= urlencode($product_image); ?>";
        var updatedUrl = baseUrl + "&size=" + encodeURIComponent(sizeSelected.value) + "&quantity=" +
            encodeURIComponent(quantity);
        document.getElementById('confirm-btn').setAttribute('href', updatedUrl);
    });
    </script>
</body>

</html>