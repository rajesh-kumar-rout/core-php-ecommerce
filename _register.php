<?php 

session_start();

require("inc/database.php");

require("inc/un-authenticate.php");

// access data
$name = trim($_POST["name"]) ?? ""; 
$email = strtolower(trim($_POST["email"])) ?? ""; 
$password = $_POST["password"] ?? ""; 
$errors = [];

// validate name
if(empty($name)) $errors["name"] = "Name is required";
else if(strlen($name) > 40) $errors["name"] = "Name must be within 40 characters";

// validate email
if(empty($email)) $errors["email"] = "Email is required";
else if(strlen($email) > 40) $errors["email"] = "Email must be within 40 characters";
else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors["email"] = "Invalid email";
else 
{
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $_POST["email"]]);
    if($stmt->fetch()) $errors["email"] = "Email already taken";
}

// validate password
if(strlen($password) > 20 || strlen($password) < 6) $errors["password"] = "Password must be within 6-20 characters";
else if(strlen(trim($password)) == 0) $errors["password"] = "Password should not contain only empty characters";

// check validation errors
if(count($errors) > 0)
{
    $_SESSION["errors"] = $errors;
    $_SESSION["data"] = $_POST;
    header("Location: /register.php");
    die();
}

// save user in db
$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "email" => $_POST["email"],
    "password" => $_POST["password"]
]);

if($result) 
{
    $_SESSION["id"] = $pdo->lastInsertId();
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["is_admin"] = false;
    $_SESSION["success"] = "Account created successfully";
    header("Location: /");
    die();
} 
else 
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
    $_SESSION["data"] = $_POST;
    header("Location: /register.php");
}