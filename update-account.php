<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT 1 FROM users WHERE email = :email AND id != :id LIMIT 1";
$stmt = $pdo->prepare($sql);	
$stmt->execute([
    "email" => $_POST["email"],
    "id" => $_SESSION["id"]
]);

if($stmt->fetch())
{
    $_SESSION["error"] = "Email already taken";
    header("Location: /edit-account.php");
    die();
}

$sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "email" => $_POST["email"],
    "id" => $_SESSION["id"],
]);

if($result)
{
    $_SESSION["success"] = "Account edited successfully";
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["name"] = $_POST["name"];
}
else 
{
    $_SESSION["success"] = "Sorry, Something went wrong.";
}

header("Location: /edit-account.php");