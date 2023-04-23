<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.id AND (products.stock IS NULL OR products.stock > cart.quantity) WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();

$sql = "SELECT * FROM settings";
$stmt = $pdo->query($sql);
$setting = $stmt->fetch();

$product_price = 0;

foreach ($products as $product) $product_price += ($product["price"] * $product["quantity"]);

$gst_amount = round($product_price * ($setting["gst"] / 100));

$total_amount = $product_price + $setting["shipping_cost"] + $gst_amount;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Cart</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <div class="container my-4">
        <?php require("inc/show-flash.php") ?>

        <?php if(count($products) == 0): ?>
            <div class="alert alert-warning">Your cart is empty</div>
        <?php else: ?>
            <div class="row g-4">
                <div class="col-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="min-width: 700px">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($products as $product): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <img class="img-fluid" height="60px" width="60px" src="<?= $product["image_url"] ?>" >
                                                <div><?= $product["name"] ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <form class="input-group" action="/create-cart.php" method="post">
                                                <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                                                <input type="number" class="form-control" name="quantity" value="<?= $product["quantity"] ?>">
                                                <button type="submit" class="btn btn-outline-secondary">Update</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="/delete-cart.php" method="post">
                                                <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                                                <button type="submit" class="btn btn-outline-secondary">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header fw-bold text-primary">Pricing Details</div>
                        <div class="card-body">
                            <div class="mb-2 pb-2 d-flex justify-content-between align-items-center border-bottom">
                                <span>Product Price</span>
                                <span>Rs. <?= $product_price ?></span>
                            </div>

                            <div class="mb-2 pb-2 d-flex justify-content-between align-items-center border-bottom">
                                <span>Gst (<?= $setting["gst"] ?>%)</span>
                                <span>Rs. <?= $gst_amount ?></span>
                            </div>

                            <div class="mb-2 pb-2 d-flex justify-content-between align-items-center border-bottom">
                                <span>Shipping Cost </span>
                                <span>Rs. <?= $setting["shipping_cost"] ?></span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span>Total Amount </span>
                                <span>Rs. <?= $total_amount ?></span>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="/checkout.php" class="btn btn-primary">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>