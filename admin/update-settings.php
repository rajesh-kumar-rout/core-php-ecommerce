<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "UPDATE settings SET shipping_cost = :shipping_cost, gst = :gst, email = :email, return_address = :return_address";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "shipping_cost" => $_POST["shipping_cost"],
    "gst" => $_POST["gst"],
    "email" => $_POST["email"],
    "return_address" => $_POST["return_address"],
]);

if($result > 0)
{
    $_SESSION["success"] = "Settings updated successfully";
    
}
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
}

header("Location: /admin/settings.php");
