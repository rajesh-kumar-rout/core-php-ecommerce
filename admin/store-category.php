<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT 1 FROM categories WHERE name = :name LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(["name" => $_POST["name"]]);

if($stmt->fetch())
{
    $_SESSION["error"] = "Category already exists";
    $_SESSION["data"] = $_POST;
    header("Location: /admin/create-category.php");
    die();
}

$sql = "INSERT INTO categories (name) VALUES (:name)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(["name" => $_POST["name"]]);

if($result == 1)
{
    $_SESSION["success"] = "Category created successfully";
    header("Location: /admin/categories.php");
    die();
}
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
}

header("Location: /admin/create-category.php");