<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.id AND (products.stock IS NULL OR products.stock > cart.quantity) WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();

$sql = "SELECT * FROM settings";
$stmt = $pdo->query($sql);
$setting = $stmt->fetch();

$product_price = 0;

foreach ($products as $product) $product_price += ($product["price"] * $product["quantity"]);

$gst_amount = round($product_price * ($setting["gst"] / 100));

$total_amount = $product_price + $setting["shipping_cost"] + $gst_amount;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Cart</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <?php require("inc/show-flash.php") ?>

    <table>
        <thead>
            <tr>
                <td>Product</td>
                <td>Quantity</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td>
                        <div>
                            <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
                            <span><?= $product["name"] ?></span>
                        </div>
                    </td>
                    <td>
                        <form action="/create-cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                            <input type="number" name="quantity" value="<?= $product["quantity"] ?>">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="/delete-cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <p>Product Price : <?= $product_price ?></p>
    <p>Gst : <?= $setting["gst"] ?></p>
    <p>Gst Amount : <?= $gst_amount ?></p>
    <p>Shipping Cost : <?= $setting["shipping_cost"] ?></p>
    <p>Total Amount : <?= $total_amount ?></p>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>