<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM addresses WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.id AND (products.stock IS NULL OR products.stock > cart.quantity) WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM settings";
$stmt = $pdo->query($sql);
$setting = $stmt->fetch(PDO::FETCH_ASSOC);

$product_price = 0;

foreach ($products as $product) $product_price += ($product["price"] * $product["quantity"]);

$gst_amount = round($product_price * ($setting["gst"] / 100));

$total_amount = $product_price + $setting["shipping_cost"] + $gst_amount;

?>

<html>
    <head>
        <?php require("inc/head.php") ?>
        <title>Checkout</title>
    </head>

    <body>
        <?php require("inc/navbar.php") ?>

        <?php require("inc/show-flash.php") ?>

        <form action="/store-order.php" method="post">
            <table>
                <thead>
                    <tr>
                        <td></td>
                        <td>Name</td>
                        <td>Mobie</td>
                        <td>Address</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($addresses as $address): ?>
                        
                        <tr>
                            <td><input type="radio" name="address_id" value="<?= $address["id"] ?>"></td>
                            <td><?= $address["name"] ?></td>
                            <td><?= $address["mobile"] ?></td>
                            <td><?= "{$address["address_line_1"]}, {$address["address_line_2"]}, {$address["city"]}, {$address["state"]}, {$address["pincode"]}" ?></td>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <p>Product Price : <?= $product_price ?></p>
            <p>Gst : <?= $setting["gst"] ?></p>
            <p>Gst Amount : <?= $gst_amount ?></p>
            <p>Shipping Cost : <?= $setting["shipping_cost"] ?></p>
            <p>Total Amount : <?= $total_amount ?></p>

            <h3>Products</h3>

            <table>
                <?php foreach($products as $product): ?>
                    <tr>
                        <td><?= $product["name"] ?> ✕ <?= $product["quantity"] ?></td>
                        <td><?= $product["price"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <button type="submit">Place Order</button>
        </form>

        <?php require("inc/remove-flash.php") ?>
    </body>
</html>