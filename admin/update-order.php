<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "UPDATE orders SET status = :status WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "id" => $_POST["order_id"],
    "status" => $_POST["status"]
]);

if($result == 1)
{
    $_SESSION["success"] = "Order updated successfully";
}
else 
{
    $_SESSION["error"] = "Sorry, An unknown error occur";
}

header("Location: /admin/order.php?order_id=" . $_POST["order_id"]);