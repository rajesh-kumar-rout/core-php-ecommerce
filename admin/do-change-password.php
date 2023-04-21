<?php 

require("db.php");

session_start();

if(!isset($_SESSION["id"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_SESSION["id"]]);
$user = $stmt->fetch();

if($user["password"] != $_POST["old_password"])
{
    $_SESSION["error"] = "Old password does not match";
    header("Location: /admin/change-password.php");
    die();
}
$sql = "UPDATE users SET password = :password WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "password" => $_POST["new_password"],
    "id" => $user["id"]
]);

if($result == 1) 
{
    $_SESSION["success"] = "Password changed successfully";
} 
else 
{
    $_SESSION["ereror"] = "Sorry, Something went wrong.";
}

header("Location: /admin/change-password.php");