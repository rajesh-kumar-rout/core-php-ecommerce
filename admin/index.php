<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: login.php");
    die();
}

$sql = "SELECT (SELECT COUNT(sliders.id) FROM sliders) AS total_sliders, (SELECT COUNT(orders.id) FROM orders WHERE status = 'Shipped') AS total_shipped_orders, (SELECT COUNT(orders.id) FROM orders WHERE status = 'Canceled') AS total_canceled_orders, (SELECT COUNT(orders.id) FROM orders WHERE status = 'Placed') AS total_placed_orders, (SELECT COUNT(products.id) FROM products) AS total_products, (SELECT COUNT(categories.id) FROM categories) AS total_categories, (SELECT COUNT(orders.id) FROM orders) AS total_orders,  (SELECT COUNT(orders.id) FROM orders WHERE status = 'Delivered') AS total_delivered_orders, (SELECT SUM(total_amount) FROM payment_details) AS total_income";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("head.php") ?>
    <title>Dashboard</title>
</head>
<body>
    <?php require("header.php") ?>

    <table>
        <thead>
            <tr>
                <td>Total Products</td>
                <td>Total Categories</td>
                <td>Total Sliders</td>
                <td>Total Orders</td>
                <td>Total Placed Orders</td>
                <td>Total Shipped Orders</td>
                <td>Total Canceled Orders</td>
                <td>Total Delivered Orders</td>
                <td>Total Income</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $data["total_products"] ?></td>
                <td><?= $data["total_categories"] ?></td>
                <td><?= $data["total_sliders"] ?></td>
                <td><?= $data["total_orders"] ?></td>
                <td><?= $data["total_placed_orders"] ?></td>
                <td><?= $data["total_shipped_orders"] ?></td>
                <td><?= $data["total_canceled_orders"] ?></td>
                <td><?= $data["total_delivered_orders"] ?></td>
                <td><?= $data["total_income"] ?></td>
            </tr>
        </tbody>
    </table>

    <?php require("footer.php") ?>
</body>
</html>