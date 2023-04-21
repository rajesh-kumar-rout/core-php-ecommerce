<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "DELETE FROM reviews WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(["id" => $_POST["review_id"]]);

if($result == 1)
{
    $_SESSION["success"] = "Review deleted successfully";
}
else
{
    $_SESSION["error"] = "Sorry, Something went wrong";
}

header("Location: /admin/reviews.php");

