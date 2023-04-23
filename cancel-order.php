<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM orders WHERE user_id = {$_SESSION["id"]} AND id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_POST["order_id"] ?? "-1"]);
$order = $stmt->fetch();

if(!($order && $order["status"] == "Placed"))
{
    $_SESSION["error"] = "Please contact the store admin to cancel the order";
    header("Location: /orders.php");
    die();
}

$sql = "UPDATE orders SET status = 'Cancel Requested' WHERE id = {$order["id"]}";
$result = $pdo->query($sql);

if($result)  $_SESSION["success"] = "Cancel request has been sent to admin successfully";
else $_SESSION["error"] = "Sorry, Something went wrong";

header("Location: /orders.php");