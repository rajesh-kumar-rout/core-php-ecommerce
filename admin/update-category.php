<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT 1 FROM categories WHERE name = :name AND id != :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "name" => $_POST["name"],
    "id" => $_POST["category_id"]
]);

if($stmt->fetch())
{
    $_SESSION["error"] = "Category already exists";
    $_SESSION["data"] = $_POST;
    header("Location: /admin/edit-category.php?category_id=" . $category["id"]);
    die();
}

$sql = "UPDATE categories SET `name` = :name WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "id" => $_POST["category_id"]
]);

if($result == 1)
{
    $_SESSION["success"] = "Category updated successfully";
    header("Location: /admin/categories.php");
}
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
    header("Location: /admin/edit-category.php?category_id=" . $category["id"]);
}

