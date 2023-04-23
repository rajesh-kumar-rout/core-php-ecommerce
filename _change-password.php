<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

// access data
$old_password = $_POST["old_password"] ?? ""; 
$new_password = $_POST["new_password"] ?? ""; 
$confirm_new_password = $_POST["confirm_new_password"] ?? ""; 
$errors = [];

// validate old password
if(empty($old_password)) $errors["old_password"] = "Old password is required";
else 
{
    $sql = "SELECT * FROM users WHERE id = {$_SESSION["id"]} LIMIT 1";
    $stmt = $pdo->query($sql);
    $user = $stmt->fetch();
    if($user["password"] != $_POST["old_password"]) $errors["old_password"] = "Old password does not match";
}

// validate new password
if(strlen($new_password) > 20 || strlen($new_password) < 6) $errors["new_password"] = "New password must be within 6-20 characters";
else if(strlen(trim($new_password)) == 0) $errors["new_password"] = "New password should not contain only empty characters";

// validate confirm new password
if($new_password != $confirm_new_password) $errors["confirm_new_password"] = "New password does not match";

// check validation errors
if(count($errors) > 0)
{
    $_SESSION["errors"] = $errors;
    $_SESSION["data"] = $_POST;
    header("Location: /change-password.php");
    die();
}

// update password in db
$sql = "UPDATE users SET password = :password WHERE id = {$user["id"]}";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute(["password" => $new_password]);

if($result == 1) $_SESSION["success"] = "Password changed successfully";
else $_SESSION["ereror"] = "Sorry, Something went wrong.";

header("Location: /change-password.php");