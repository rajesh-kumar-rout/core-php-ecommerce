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

    <div class="container my-4">
        <?php require("inc/show-flash.php") ?>

        <?php if(count($products) == 0): ?>
            <div class="alert alert-warning">Your wishlist is empty</div>
        <?php else: ?>
            <h5 class="fw-bold text-primary border-bottom border-primary pb-2 mb-3">Wishlists</h5>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                <?php foreach($products as $product): ?>
                    <a class="text-dark text-center text-decoration-none" href="/details.php?product_id=<?= $product["id"] ?>">
                        <img class="img-fluid" src="<?= $product["image_url"] ?>" alt="">
                        <p class="fw-bold mt-2 mb-1"><?= $product["name"] ?></p>
                        <p class="fw-bold text-primary mb-2">Rs. <?= $product["price"] ?></p>
                        <form action="delete-wishlist.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                            <button class="btn btn-sm btn-outline-secondary" type="submit">Remove</button>
                        </form>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>