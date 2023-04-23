<?php 

session_start();

require("inc/database.php");

require("inc/un-authenticate.php");

// access data
$email = strtolower(trim($_POST["email"])) ?? "";
$password = $_POST["password"] ?? "";
$errors = [];

// validate email
if(empty($email)) $errors["email"] = "Email is required";

// validate password
if(empty($password)) $errors["password"] = "Password is required";

// check validation errors
if(count($errors) > 0)
{
    $_SESSION["errors"] = $errors;
    $_SESSION["data"] = $_POST;
    header("Location: /login.php");
    die();
}

// retrive user by credentials
$sql = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "email" => $_POST["email"],
    "password" => $_POST["password"],
]);
$user = $stmt->fetch();

// login user if exists
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