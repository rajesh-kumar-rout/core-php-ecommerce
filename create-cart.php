<?php

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_POST["product_id"]]);
$product = $stmt->fetch();

if($product["stock"] && $product["stock"] < $_POST["quantity"])
{
    $_SESSION["error"] = "We do not have " . $_POST["quantity"] . " " . $product["name"] . " to fullfill your request";
    echo "<script>javascript:history.go(-1)</script>";
    die();
}

$sql = "SELECT * FROM cart WHERE product_id = :product_id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "product_id" => $_POST["product_id"],
    "user_id" => $_SESSION["id"]
]);
$cart = $stmt->fetch();

if($cart)
{
    $sql = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        "product_id" => $_POST["product_id"],
        "user_id" => $_SESSION["id"],
        "quantity" => $_POST["quantity"],
    ]);
    if($result) $_SESSION["success"] = "Product updated in cart successfully";
    else $_SESSION["error"] = "Sorry, An unknown error occured";
}
else 
{
    $sql = "INSERT INTO cart (product_id, user_id, quantity) VALUES (:product_id, :user_id, :quantity)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        "product_id" => $_POST["product_id"],
        "user_id" => $_SESSION["id"],
        "quantity" => $_POST["quantity"],
    ]);
    if($result) $_SESSION["success"] = "Product added to cart successfully";
    else $_SESSION["error"] = "Sorry, An unknown error occured";
}

echo "<script>javascript:history.go(-1)</script>";
