<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

// access data
$name = trim($_POST["name"]) ?? ""; 
$mobile = trim($_POST["mobile"]) ?? ""; 
$address_line_1 = trim($_POST["address_line_1"]) ?? ""; 
$address_line_2 = trim($_POST["address_line_2"]) ?? ""; 
$city = trim($_POST["city"]) ?? ""; 
$state = trim($_POST["state"]) ?? ""; 
$pincode = trim($_POST["pincode"]) ?? ""; 
$errors = [];

// validate name
if(empty($name)) $errors["name"] = "Name is required";
else if(strlen($name) > 40) $errors["name"] = "Name must be within 40 characters";

// validate mobile
if(empty($mobile)) $errors["mobile"] = "Mobile is required";
else if(!filter_var($mobile, FILTER_VALIDATE_INT) || $mobile < 1000000000 || $mobile > 9999999999) $errors["mobile"] = "Invalid mobile number";

// validate address line 1
if(empty($address_line_1)) $errors["address_line_1"] = "Address line 1 is required";
else if(strlen($address_line_1) > 40) $errors["address_line_1"] = "Address line 1 must be within 40 characters";

// validate address line 2
if(empty($address_line_2)) $errors["address_line_2"] = "Address line 2 is required";
else if(strlen($address_line_2) > 40) $errors["address_line_2"] = "Address line 2 must be within 40 characters";

// validate city
if(empty($city)) $errors["city"] = "City is required";
else if(strlen($city) > 20) $errors["city"] = "City must be within 20 characters";

// validate state
if(empty($state)) $errors["state"] = "State is required";
else if(strlen($state) > 20) $errors["state"] = "State must be within 20 characters";

// validate pincode
if(empty($pincode)) $errors["pincode"] = "Pincode is required";
else if(!filter_var($pincode, FILTER_VALIDATE_INT) || $pincode < 100000 || $pincode > 999999) $errors["pincode"] = "Invalid pincode";

// check validation errors
if(count($errors) > 0)
{
    $_SESSION["errors"] = $errors;
    $_SESSION["data"] = $_POST;
    header("Location: /create-address.php");
    die();
}

// save address in db
$sql = "INSERT INTO addresses (user_id, name, mobile, address_line_1, address_line_2, city, state, pincode) VALUES ('{$_SESSION["id"]}', :name, :mobile, :address_line_1, :address_line_2, :city, :state, :pincode)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "mobile" => $_POST["mobile"],
    "address_line_1" => $_POST["address_line_1"],
    "address_line_2" => $_POST["address_line_2"],
    "city" => $_POST["city"],
    "state" => $_POST["state"],
    "pincode" => $_POST["pincode"]
]);

if($result == 1) 
{
    $_SESSION["success"] = "Address created successfully";
}
else
{
    $_SESSION["error"] = "Sorry, Something went wrong.";
    $_SESSION["data"] = $_POST;
}

header("Location: /addresses.php");