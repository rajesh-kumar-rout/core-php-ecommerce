<?php

require("admin/db.php");

session_start();

$sql = "SELECT * FROM wishlists WHERE product_id = :product_id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "product_id" => $_POST["product_id"],
    "user_id" => $_SESSION["id"]
]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

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

if($result)
{
    $_SESSION["success"] = "Product added to wishlist successfully";
}
else 
{
    $_SESSION["error"] = "Sorry, An unknown error occured";
}

header("Location: /details.php?product_id=" . $_POST["product_id"]);
