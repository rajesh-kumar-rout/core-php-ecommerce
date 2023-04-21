<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/products.php");
    die();
}

$image_url = "../uploads/" . rand(10000, 9999999999999999) . $_FILES["image"]["name"];

move_uploaded_file($_FILES["image"]["tmp_name"], $image_url);

$sql = "INSERT INTO products (name, price, stock, description, image_url, category_id, is_active) VALUES (:name, :price, :stock, :description, :image_url, :category_id, :is_active)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "price" => $_POST["price"],
    "stock" => $_POST["stock"],
    "description" => $_POST["description"],
    "image_url" => $image_url,
    "category_id" => $_POST["category_id"],
    "is_active" => isset($_POST["is_active"]),
]);

if($result == 1)
{
    $_SESSION["success"] = "Product created successfully";
    header("Location: /admin/products.php");
}
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
    header("Location: /admin/create-product.php");
}
