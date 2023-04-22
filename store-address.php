<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "INSERT INTO addresses (user_id, name, mobile, address_line_1, address_line_2, city, state, pincode) VALUES (:user_id, :name, :mobile, :address_line_1, :address_line_2, :city, :state, :pincode)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "mobile" => $_POST["mobile"],
    "address_line_1" => $_POST["address_line_1"],
    "address_line_2" => $_POST["address_line_2"],
    "city" => $_POST["city"],
    "state" => $_POST["state"],
    "pincode" => $_POST["pincode"],
    "user_id" => $_SESSION["id"],
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