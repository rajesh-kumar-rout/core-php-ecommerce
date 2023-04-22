<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "UPDATE addresses SET name = :name, mobile = :mobile, address_line_1 = :address_line_1, address_line_2 = :address_line_2, city = :city, state = :state, pincode = :pincode WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "name" => $_POST["name"],
    "mobile" => $_POST["mobile"],
    "address_line_1" => $_POST["address_line_1"],
    "address_line_2" => $_POST["address_line_2"],
    "city" => $_POST["city"],
    "state" => $_POST["state"],
    "pincode" => $_POST["pincode"],
    "id" => $_POST["id"],
    "user_id" => $_SESSION["id"],
]);

if($result) 
{
    $_SESSION["success"] = "Address updated successfully";
}
else 
{
    $_SESSION["error"] = "Sorry, An unknown error occured";
    $_SESSION["data"] = $_POST;
}

header("Location: /addresses.php");