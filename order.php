<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM orders WHERE id = :id AND user_id = :user_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "id" => $_GET["order_id"],
    "user_id" => $_SESSION["id"]
]);
$order = $stmt->fetch();

$sql = "SELECT * FROM ordered_products WHERE order_id = :order_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "order_id" => $_GET["order_id"]
]);
$products = $stmt->fetchAll();

$sql = "SELECT * FROM payment_details WHERE order_id = :order_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "order_id" => $_GET["order_id"]
]);
$payment = $stmt->fetch();

$sql = "SELECT * FROM shipping_addresses WHERE order_id = :order_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "order_id" => $_GET["order_id"]
]);
$shipping = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Order Details</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <div class="container my-4">
        <?php require("inc/show-flash.php") ?>

        <div class="row g-4">
            <div class="col-12 col-md-8">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img height="60px" width="60px" src="<?= $product["image_url"] ?>" class="img-fluid">
                                        <div><?= $product["name"] ?></div>
                                    </div>
                                </td>
                                <td>Rs. <?= $product["price"] ?></td>
                                <td><?= $product["quantity"] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header fw-bold text-primary">Pricing Details</div>
                    <div class="card-body">
                        <div class="mb-2 pb-2 d-flex justify-content-between align-items-center border-bottom">
                            <span>Product Price</span>
                            <span>Rs. <?= $payment["product_price"] ?></span>
                        </div>

                        <div class="mb-2 pb-2 d-flex justify-content-between align-items-center border-bottom">
                            <span>Gst (<?= $payment["gst"] ?>%)</span>
                            <span>Rs. <?= $payment["gst_amount"] ?></span>
                        </div>

                        <div class="mb-2 pb-2 d-flex justify-content-between align-items-center border-bottom">
                            <span>Shipping Cost </span>
                            <span>Rs. <?= $payment["shipping_cost"] ?></span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span>Total Amount </span>
                            <span>Rs. <?= $payment["total_amount"] ?></span>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header fw-bold text-primary">Shipping Address</div>

                    <div class="card-body">
                        <div class="mb-2 pb-2 border-bottom">Name - <?= $shipping["name"] ?></div>
                        <div class="mb-2 pb-2 border-bottom">Mobile - <?= $shipping["mobile"] ?></div>
                        <div>Address - <?= $shipping["address"] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>