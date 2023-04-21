<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "DELETE FROM sliders WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(["id" => $_POST["slider_id"]]);

if($result == 1)
{
    $_SESSION["success"] = "Slider deleted successfully";
}
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
}

header("Location: /admin/sliders.php");