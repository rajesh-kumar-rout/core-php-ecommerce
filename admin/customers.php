<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /index.php");
    die();
}

$sql = "SELECT users.*, (SELECT COUNT(orders.id) FROM orders WHERE orders.user_id = users.id) AS total_orders FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("head.php") ?>
    <title>Customers</title>
</head>
<body>
    <?php require("header.php") ?>

    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Total Orders</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?= $user["id"] ?></td>
                    <td><?= $user["name"] ?></td>
                    <td><?= $user["email"] ?></td>
                    <td><?= $user["total_orders"] ?></td>
                    <td><?= $user["created_at"] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>