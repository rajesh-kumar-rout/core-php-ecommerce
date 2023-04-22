<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT orders.*, payment_details.total_amount, (SELECT COUNT(*) FROM ordered_products WHERE ordered_products.order_id = orders.id) as total_products FROM orders INNER JOIN payment_details ON payment_details.order_id = orders.id WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$orders = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Orders</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <?php require("inc/show-flash.php") ?>

    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Status</td>
                <td>Total Amount</td>
                <td>Total Product</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order): ?>
                <tr>
                    <td><?php echo $order["id"] ?></td>
                    <td><?php echo $order["status"] ?></td>
                    <td><?php echo $order["total_amount"] ?></td>
                    <td><?php echo $order["total_products"] ?></td>
                    <td><?php echo $order["created_at"] ?></td>
                    <td>
                        <a href="/order.php?order_id=<?= $order["id"] ?>">View</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>