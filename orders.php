<?php 

require("admin/db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT orders.*, payment_details.total_amount, (SELECT COUNT(*) FROM ordered_products WHERE ordered_products.order_id = orders.id) as total_products FROM orders INNER JOIN payment_details ON payment_details.order_id = orders.id WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "user_id" => $_SESSION["id"]
]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders</title>
</head>
<body>

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
</body>
</html>