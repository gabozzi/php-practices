<?php
session_start();

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// Clear the cart by destroying the session cart array
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}

// Check if the product details are passed via the URL and add to cart
if (isset($_GET['name'], $_GET['price'], $_GET['image'], $_GET['size'], $_GET['quantity'])) {
    $product_name = sanitize_input($_GET['name']);
    $product_price = filter_var($_GET['price'], FILTER_VALIDATE_FLOAT);
    $product_image = sanitize_input($_GET['image']);
    $product_size = sanitize_input($_GET['size']);
    $product_quantity = filter_var($_GET['quantity'], FILTER_VALIDATE_INT);

    if ($product_price === false || $product_price <= 0) {
        $product_price = 0.00;
    }

    // Store the product in the session cart
    $cart_item = [
        'name' => $product_name,
        'price' => $product_price,
        'image' => $product_image,
        'size' => $product_size,
        'quantity' => $product_quantity,
        'total' => $product_price * $product_quantity
    ];

    // Add to cart or initialize the cart
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'][] = $cart_item;
    } else {
        $_SESSION['cart'] = [$cart_item];
    }
}

// Handle the cart update when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $itemName => $newQuantity) {
        // Ensure the quantity is a valid number and greater than 0
        $newQuantity = intval($newQuantity);

        if ($newQuantity > 0) {
            // Find the item in the cart and update its quantity
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['name'] == $itemName) {
                    $_SESSION['cart'][$index]['quantity'] = $newQuantity;
                    // Optionally, update the total price based on the new quantity
                    $_SESSION['cart'][$index]['total'] = $item['price'] * $newQuantity;
                    break;
                }
            }
        }
    }

    // After updating, redirect to refresh the cart page
    header("Location: cart.php");
    exit();
}

// Handle removing items from the cart
if (isset($_GET['remove'])) {
    $remove_index = $_GET['remove'];
    if (isset($_SESSION['cart'][$remove_index])) {
        unset($_SESSION['cart'][$remove_index]);
        // Reindex the cart array to prevent gaps in the indices
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        // Redirect to avoid re-submitting form on refresh
        header("Location: cart.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for trash icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    .header-icon {
        font-size: 40px;
        margin-right: 10px;
    }


    .cart-table img {
        width: 80px;
        height: auto;
    }

    .cart-table td {
        vertical-align: middle;
    }

    .cart-table .trash-btn {
        color: red;
        cursor: pointer;
    }

    .total-row td {
        font-weight: bold;
    }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="text-dark py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-shop-window header-icon"></i>
                <h1 class="m-0">Learn IT Easy Online Shop</h1>
            </div>
            <div class="cart-button">
                <a href="cart.php" class="btn btn-outline-primary position-relative">
                    <i class="fas fa-shopping-cart"></i> Cart
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

    <div class="container mt-5">

        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <form action="cart.php" method="POST">
            <!-- Move the form tag here to wrap the whole table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <tr>
                        <td><img src="<?= $item['image']; ?>" width="50" alt="<?= $item['name']; ?>"></td>
                        <td><?= $item['name']; ?></td>
                        <td><?= $item['size']; ?></td>
                        <td>
                            <input type="number" name="quantity[<?= $item['name']; ?>]" value="<?= $item['quantity']; ?>"
                                class="form-control" min="1">
                        </td>
                        <td>$<?= number_format($item['price'], 2); ?></td>
                        <td>$<?= number_format($item['total'], 2); ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $index; ?>" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Remove
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="6" class="text-right">
                            <div class="d-flex justify-content-between mt-4">
                                <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
                                <button type="submit" name="update_cart" class="btn btn-success">Update Cart</button>
                                <a href="checkout.php" class="btn btn-primary">Checkout</a>
                                <!-- Fixed the link to 'checkout.php' -->
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>

        <?php else: ?>
        <p>Your cart is empty.</p>
        <?php endif; ?>

    </div>


    <!-- Bootstrap JS and FontAwesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>

</html>