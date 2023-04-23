<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

// access data
$name = trim($_POST["name"]) ?? ""; 
$email = strtolower(trim($_POST["email"])) ?? ""; 
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
    $sql = "SELECT * FROM users WHERE email = :email AND id != {$_SESSION["id"]} LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $_POST["email"]]);
    if($stmt->fetch()) $errors["email"] = "Email already taken";
}

// check validation errors
if(count($errors) > 0)
{
    $_SESSION["errors"] = $errors;
    $_SESSION["data"] = $_POST;
    header("Location: /edit-account.php");
    die();
}

// update user in db
$sql = "UPDATE users SET name = :name, email = :email WHERE id = {$_SESSION["id"]}";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "email" => $_POST["email"]
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