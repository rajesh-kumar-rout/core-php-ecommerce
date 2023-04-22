<?php 

session_start();

require("inc/database.php");

require("inc/un-authenticate.php");


$sql = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "email" => $_POST["email"],
    "password" => $_POST["password"],
]);
$user = $stmt->fetch();

if($user)
{
    $_SESSION["id"] = $user["id"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["name"] = $user["name"];
    $_SESSION["is_admin"] = $user["is_admin"];
    $_SESSION["user"] = $user;
    header("Location: /");
    die();
}
else 
{
    $_SESSION["error"] = "Invalid email or password";
    $_SESSION["data"] = $_POST;
    header("Location: /login.php");
}