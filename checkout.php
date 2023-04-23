<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM addresses WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.id AND (products.stock IS NULL OR products.stock > cart.quantity) WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM settings";
$stmt = $pdo->query($sql);
$setting = $stmt->fetch(PDO::FETCH_ASSOC);

$product_price = 0;

foreach ($products as $product) $product_price += ($product["price"] * $product["quantity"]);

$gst_amount = round($product_price * ($setting["gst"] / 100));

$total_amount = $product_price + $setting["shipping_cost"] + $gst_amount;

$_SESSION["total_amount"] = $total_amount;
$_SESSION["total_items"] = count($products);

?>

<html>
    <head>
        <?php require("inc/head.php") ?>
        <title>Checkout</title>
    </head>

    <body>
        <?php require("inc/navbar.php") ?>


        <div class="container my-4">
            <?php require("inc/show-flash.php") ?>

            <?php if(count($products) == 0): ?>
                <div class="alert alert-warning mb-3">Your cart is empty</div>
            <?php else: ?>
                <form action="/store-order.php" method="post">
                    <div class="row g-4">
                        <div class="col-12 col-md-8">
                            <div class="card">
                                <div class="card-header fw-bold text-primary">Select a address</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="min-width: 600px;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Mobie</th>
                                                    <th>Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(count($addresses) == 0): ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            No address added <a href="/create-address.php">Create One</a>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php foreach($addresses as $address): ?>
                                                    <tr>
                                                        <td class="text-center"><input class="form-check-input" type="radio" name="address_id" value="<?= $address["id"] ?>"></td>
                                                        <td><?= $address["name"] ?></td>
                                                        <td><?= $address["mobile"] ?></td>
                                                        <td><?= "{$address["address_line_1"]}, {$address["address_line_2"]}, {$address["city"]}, {$address["state"]}, {$address["pincode"]}" ?></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
                                        <span>Gst </span>
                                        <span>Rs. <?= $setting["gst"] ?></span>
                                    </div>

                                    <div class="mb-2 pb-2 d-flex justify-content-between align-items-center border-bottom">
                                        <span>Gst Amount </span>
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
                            </div>

                            <div class="card mt-3">
                                <div class="card-header fw-bold text-primary">Products</div>
                                <div class="card-body">
                                    <?php foreach($products as $product): ?>
                                        <div class="border-bottom pb-2 mb-2 lcblml">
                                            <div><?= $product["name"] ?> ✕ <?= $product["quantity"] ?></div>
                                            <div>Rs. <?= $product["price"] ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header fw-bold text-primary">Payment Method</div>
                                <div class="card-body">
                                    <div class="form-check">
                                        <input name="payment_method" id="cod" type="radio" class="form-check-input">
                                        <label for="cod" class="form-check-label">Cash on delivery</label>
                                    </div>
                                    <div class="form-check mt-3">
                                        <input name="payment_method" id="debit_card" type="radio" class="form-check-input">
                                        <label for="debit_card" class="form-check-label">Debit Card</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 w-100">Place Order</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <?php require("inc/remove-flash.php") ?>
    </body>
</html>