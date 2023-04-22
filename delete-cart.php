<?php

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "user_id" => $_SESSION["id"],
    "product_id" => $_POST["product_id"]
]);

if($result) $_SESSION["success"] = "Product removed from cart successfully";
else  $_SESSION["error"] = "Sorry, An unknown error occured";

header("Location: /cart.php");
