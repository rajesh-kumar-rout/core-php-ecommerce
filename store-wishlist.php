<?php

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM products WHERE id = :product_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(["product_id" => $_POST["product_id"] ?? -1]);
$product = $stmt->fetch();

if(!$product)
{
    header("Location: /");
    die();
}

$sql = "SELECT * FROM wishlists WHERE product_id = :product_id AND user_id = {$_SESSION["id"]}";
$stmt = $pdo->prepare($sql);
$stmt->execute(["product_id" => $_POST["product_id"]]);
$product = $stmt->fetch();

if($product)
{
    $_SESSION["error"] = "Product already in wishlist";
    header("Location: /details.php?product_id=" . $_POST["product_id"]);
    die();
}

$sql = "INSERT INTO wishlists (product_id, user_id) VALUES (:product_id, :user_id)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "product_id" => $_POST["product_id"],
    "user_id" => $_SESSION["id"]
]);

if($result) $_SESSION["success"] = "Product added to wishlist successfully";
else $_SESSION["error"] = "Sorry, An unknown error occured";

header("Location: /details.php?product_id=" . $_POST["product_id"]);
