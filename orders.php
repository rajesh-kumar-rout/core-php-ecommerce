<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT orders.*, payment_details.total_amount, (SELECT COUNT(*) FROM ordered_products WHERE ordered_products.order_id = orders.id) as total_products FROM orders INNER JOIN payment_details ON payment_details.order_id = orders.id WHERE user_id = {$_SESSION["id"]} ORDER BY orders.created_at DESC";
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

    <div class="container my-4">
        <?php require("inc/show-flash.php") ?>

        <div class="card">
            <div class="card-header fw-bold text-primary">Orders</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" style="min-width: 700px">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Total Amount</th>
                                <th>Total Product</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($orders) == 0): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No orders found</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach($orders as $order): ?>
                                <tr>
                                    <td><?= $order["id"] ?></td>
                                    <td><?= $order["status"] ?></td>
                                    <td><?= $order["total_amount"] ?></td>
                                    <td><?= $order["total_products"] ?></td>
                                    <td><?= $order["created_at"] ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-secondary" href="/order.php?order_id=<?= $order["id"] ?>">View</a>

                                        <?php if($order["status"] == "Placed"): ?>
                                            <form action="/cancel-order.php" method="post" class="d-inline-block">
                                                <input type="hidden" name="order_id" value="<?= $order["id"] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Cancel</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>