<?php 

require("admin/db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT * FROM orders WHERE id = :id AND user_id = :user_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "id" => $_GET["order_id"],
    "user_id" => $_SESSION["id"]
]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM ordered_products WHERE order_id = :order_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "order_id" => $_GET["order_id"]
]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM payment_details WHERE order_id = :order_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "order_id" => $_GET["order_id"]
]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM shipping_addresses WHERE order_id = :order_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "order_id" => $_GET["order_id"]
]);
$shipping = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Details</title>
</head>
<body>

    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Image</td>
                <td>Price</td>
                <td>Quantity</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td><?php echo $product["name"] ?></td>
                    <td>
                        <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
                    </td>
                    <td><?php echo $product["price"] ?></td>
                    <td><?php echo $product["quantity"] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <h2>Payment Details</h2>
    <table>
        <tr>
            <td>Total Amount</td>
            <td><?= $payment["total_amount"] ?></td>
        </tr>
        <tr>
            <td>Product Price</td>
            <td><?= $payment["product_price"] ?></td>
        </tr>
        <tr>
            <td>Shipping Cost</td>
            <td><?= $payment["shipping_cost"] ?></td>
        </tr>
        <tr>
            <td>Gst <?= $payment["gst"] ?></td>
            <td><?= $payment["gst_amount"] ?></td>
        </tr>
    </table>

    <h2>Shipping Address</h2>
    <table>
        <tr>
            <td>Name</td>
            <td><?= $shipping["name"] ?></td>
        </tr>
        <tr>
            <td>Mobie</td>
            <td><?= $shipping["mobile"] ?></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><?= $shipping["address"] ?></td>
        </tr>
    </table>

    <form action="/admin/update-order.php" method="post">
        <input type="hidden" name="order_id" value="<?= $order["id"] ?>">
        <h2>Status</h2>
        <table>
                <tr>
                    <td>
                        <label for="status">Status</label>
                    </td>
                    <td>
                        <select name="status" id="status">
                            <option <?= $order["status"] == "Placed" ? "selected" : "" ?> value="Placed">Placed</option>
                            <option <?= $order["status"] == "Shipped" ? "selected" : "" ?> value="Shipped">Shipped</option>
                            <option <?= $order["status"] == "Rejected" ? "selected" : "" ?> value="Rejected">Rejected</option>
                            <option <?= $order["status"] == "Canceled" ? "selected" : "" ?> value="Canceled">Canceled</option>
                            <option <?= $order["status"] == "Delivered" ? "selected" : "" ?> value="Delivered">Delivered</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Submit</button>
                    </td>
                </tr>
        </table>
    </form>
</body>
</html>