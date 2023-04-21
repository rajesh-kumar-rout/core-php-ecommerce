<?php 

require("db.php");

session_start();

if(isset($_SESSION["email"]))
{
    header("Location: index.php");
    die();
}

$sql = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "email" => $_POST["email"],
    "password" => $_POST["password"],
]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user)
{
    $_SESSION["id"] = $user["id"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["name"] = $user["name"];
    $_SESSION["is_admin"] = $user["is_admin"];
    header("Location: index.php");
    die();
}
else 
{
    $_SESSION["error"] = "Invalid email or password";
    $_SESSION["data"] = $_POST;
    header("Location: login.php");
}