<?php

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM sliders";
$stmt = $pdo->query($sql);
$sliders = $stmt->fetchAll();

$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();

$sql = "SELECT * FROM products WHERE is_active = 1";

if(isset($_GET["category_id"])) $sql .= " AND category_id = :category_id";

$stmt = $pdo->prepare($sql);

if(isset($_GET["category_id"])) $stmt->execute(["category_id" => $_GET["category_id"]]);
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

    <?php foreach($categories as $category): ?>
        <a href="/products.php?category_id=<?= $category["id"] ?>"><?= $category["name"] ?></a>
    <?php endforeach; ?>

    <?php foreach($products as $product): ?>
        <div>
            <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
            <h4><?= $product["name"] ?></h4>
            <p><?= $product["price"] ?></p>
        </div>
    <?php endforeach; ?>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>