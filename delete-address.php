<?php

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "DELETE FROM addresses WHERE user_id = :user_id AND id = :id";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    "user_id" => $_SESSION["id"],
    "id" => $_POST["address_id"]
]);

if($result) $_SESSION["success"] = "Address deleted successfully";
else $_SESSION["error"] = "Sorry, An unknown error occured";

header("Location: /addresses.php");
