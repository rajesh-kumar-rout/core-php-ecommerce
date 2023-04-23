<?php

session_start();

require("inc/database.php");

$sql = "SELECT * FROM products WHERE is_active = 1 AND (`name` LIKE :search OR `description` LIKE :search)";
$stmt = $pdo->prepare($sql);

$search = isset($_GET["search"]) ? $_GET["search"] :  "";
$search = "%{$search}%";

$stmt->bindParam(":search", $search);
$stmt->execute();
$products = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Search Products</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <?php require("inc/show-flash.php") ?>

    <div class="container my-4">
        <div class="card mx-auto mb-4" style="max-width: 700px;">
            <div class="card-header fw-bold text-primary">Search</div>
            <div class="card-body">
                <form class="input-group">
                    <input type="search" class="form-control" value="<?= $_GET["search"] ?? "" ?>" name="search">
                    <button type="submit" class="btn btn-outline-secondary">Search</button>
                </form>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4">
            <?php foreach($products as $product): ?>
                <a class="text-dark text-center text-decoration-none" href="/details.php?product_id=<?= $product["id"] ?>">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>" alt="">
                    <p class="fw-bold mt-2 mb-1"><?= $product["name"] ?></p>
                    <p class="fw-bold text-primary">Rs. <?= $product["price"] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>