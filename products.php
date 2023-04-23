<?php

session_start();

require("inc/database.php");

// access data
$category_id = $_GET["category_id"] ?? -1;

// fetch categories
$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();

// fetch products
$sql = "SELECT * FROM products WHERE is_active = 1";

if($category_id != -1) $sql .= " AND category_id = :category_id";

$stmt = $pdo->prepare($sql);

if($category_id != -1)  $stmt->execute(["category_id" => $category_id]);
else $stmt->execute();

$products = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Products</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <?php require("inc/show-flash.php") ?>

    <div class="container my-4">
        <div class="row g-5">
            <div class="col-12 col-md-3">
                <div class="list-group">
                    <a href="/products.php" class="list-group-item list-group-item-action <?= $category_id == -1 ? "active" : "" ?>">All</a>

                    <?php foreach($categories as $category): ?>
                        <a 
                            href="/products.php?category_id=<?= $category["id"] ?>" 
                            class="list-group-item list-group-item-action <?= $category_id == $category["id"] ? "active" : "" ?>"
                        >
                            <?= $category["name"] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-12 col-md-9">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <?php foreach($products as $product): ?>
                        <a class="text-dark text-center text-decoration-none" href="/details.php?product_id=<?= $product["id"] ?>">
                            <img class="img-fluid" src="<?= $product["image_url"] ?>" alt="">
                            <p class="fw-bold mt-2 mb-1"><?= $product["name"] ?></p>
                            <p class="fw-bold text-primary">Rs. <?= $product["price"] ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>