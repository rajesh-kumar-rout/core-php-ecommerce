<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM users WHERE id = {$_SESSION["id"]} LIMIT 1";
$stmt = $pdo->query($sql);
$user = $stmt->fetch();

if($user["password"] != $_POST["old_password"])
{
    $_SESSION["error"] = "Old password does not match";
    header("Location: /change-password.php");
    die();
}
$sql = "UPDATE users SET password = :password WHERE id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "password" => $_POST["new_password"],
    "id" => $user["id"]
]);

if($result == 1) $_SESSION["success"] = "Password changed successfully";
else $_SESSION["ereror"] = "Sorry, Something went wrong.";

header("Location: /change-password.php");