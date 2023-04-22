<?php

require("admin/db.php");

session_start();

$sql = "DELETE FROM wishlists WHERE product_id = :product_id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "user_id" => $_SESSION["id"],
    "product_id" => $_POST["product_id"]
]);

if($result)
{
    $_SESSION["success"] = "Product removed from wishlist successfully";
}
else 
{
    $_SESSION["error"] = "Sorry, An unknown error occured";
}

header("Location: /wishlists.php");
