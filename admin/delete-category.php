<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "DELETE FROM categories WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(["id" => $_POST["category_id"]]);

if($result == 1)
{
    $_SESSION["success"] = "Category deleted successfully";
}
else 
{
    $_SESSION["error"] = "Sorry, An unknown error occur";
}

header("Location: /admin/categories.php");