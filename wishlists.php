<?php

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM wishlists INNER JOIN products ON products.id = wishlists.product_id WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Wishlists</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <?php require("inc/show-flash.php") ?>

    <?php foreach($products as $product): ?>
        <a href="/details.php?product_id=<?= $product["id"] ?>">
            <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">

            <h4><?= $product["name"] ?></h4>

            <p><?= $product["price"] ?></p>

            <form action="/delete-wishlist.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                <button type="submit">Remove</button>
            </form>
        </a>
    <?php endforeach; ?>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>