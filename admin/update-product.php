<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_POST["product_id"]]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_FILES["image"]) && $_FILES["image"]["size"] != 0)
{
    $image_url = "../uploads/" . rand(100, 999999999) . $_FILES["image"]["name"];

    move_uploaded_file($_FILES["image"]["tmp_name"], $image_url);
}

$sql = "UPDATE products SET `name` = :name, price = :price, stock = :stock, is_active = :is_active, description = :description, image_url = :image_url, category_id = :category_id WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "price" => $_POST["price"],
    "stock" => $_POST["stock"],
    "description" => $_POST["description"],
    "image_url" => isset($image_url) ? $image_url : $product["image_url"],
    "category_id" => $_POST["category_id"],
    "is_active" => isset($_POST["is_active"]),
    "id" => $_POST["product_id"],
]);

if($result == 1)
{
    $_SESSION["success"] = "Product updated successfully";
    header("Location: /admin/products.php");
}
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
    $_SESSION["data"] = $_POST;
    header("Location: /admin/edit-product.php?product_id=" . $product["id"]);
}

