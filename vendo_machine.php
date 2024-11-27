<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vending Machine</title>
</head>

<body>

    <form method="post" action="">
        <fieldset style="width: 600px; padding: 10px;">
            <legend><b>Vendo Machine</b></legend>

            <label>Product:</label><br>
            <input type="checkbox" name="drinks[]" value="Coke"> Coke - P20<br>
            <input type="checkbox" name="drinks[]" value="Sprite"> Sprite - P20<br>
            <input type="checkbox" name="drinks[]" value="Royal"> Royal - P20<br>
            <input type="checkbox" name="drinks[]" value="Pepsi"> Pepsi - P20<br>
            <input type="checkbox" name="drinks[]" value="Mountain Dew"> Mountain Dew - P20<br>
        </fieldset>

        <fieldset style="width: 600px; padding: 10px;">
            <legend><b>Options</b></legend>

            <label for="size">Select Size:</label>
            <select name="size" id="size" required>
                <option value="Regular">Regular</option>
                <option value="Large">Large (+P5)</option>
                <option value="Extra Large">Extra Large (+P10)</option>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1" required>

            <button type="submit" name="checkout">Checkout</button>
        </fieldset>
    </form>

    <?php
    if (isset($_POST['checkout'])) {
        $selectedDrinks = $_POST['drinks'] ?? [];
        $size = $_POST['size'];
        $quantity = (int)$_POST['quantity'];

        if (empty($selectedDrinks)) {
            echo '<p>Please select at least one drink.</p>';
        } else {
            $basePrice = 20;
            $sizePrice = 0;

            if ($size === "Large") {
                $sizePrice = 5;
            } elseif ($size === "Extra Large") {
                $sizePrice = 10;
            }

            $totalPrice = 0;
            foreach ($selectedDrinks as $drink) {
                $totalPrice += ($basePrice + $sizePrice) * $quantity;
            }

            echo "<h3>Receipt</h3>";
            echo "<p>Selected Drinks: " . implode(", ", $selectedDrinks) . "</p>";
            echo "<p>Size: $size</p>";
            echo "<p>Quantity: $quantity</p>";
            echo "<p><strong>Total Cost: P$totalPrice</strong></p>";
        }
    }
    ?>

</body>

</html>