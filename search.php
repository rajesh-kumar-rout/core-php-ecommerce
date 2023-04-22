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

    <form>
        <input type="search" value="<?= $_GET["search"] ?? "" ?>" name="search">
        <button type="submit">Search</button>
    </form>

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