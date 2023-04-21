<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$image_url = "../uploads/" . rand(1000000, 999999999999) . $_FILES["image"]["name"];

move_uploaded_file($_FILES["image"]["tmp_name"], $image_url);

$sql = "INSERT INTO sliders (image_url) VALUES (:image_url)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(["image_url" => $image_url]);

if($result == 1)
{
    $_SESSION["success"] = "Slider created successfully";
}
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
}

header("Location: /admin/sliders.php");