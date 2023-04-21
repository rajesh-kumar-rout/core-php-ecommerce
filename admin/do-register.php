<?php 

require("db.php");

session_start();

if(isset($_SESSION["email"]))
{
    header("Location: /admin/index.php");
    die();
}

$sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(["email" => $_POST["email"]]);

if($stmt->fetch())
{
    $_SESSION["error"] = "Email already taken";
    $_SESSION["data"] = $_POST;
    header("Location: /admin/register.php");
    die();
}

$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "email" => $_POST["email"],
    "password" => $_POST["password"]
]);

if($result == 1) 
{
    $_SESSION["id"] = $pdo->lastInsertId();
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["is_admin"] = false;
    $_SESSION["success"] = "Account created successfully";
    header("Location: /admin/index.php");
    die();
} 
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
    $_SESSION["data"] = $_POST;
    header("Location: /admin/register.php");
}