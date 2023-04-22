<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.id AND (products.stock IS NULL OR products.stock > cart.quantity) WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();

$sql = "SELECT * FROM addresses WHERE user_id = :user_id AND id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "user_id" => $_SESSION["id"],
    "id" => $_POST["address_id"]
]);
$address = $stmt->fetch();

$sql = "SELECT * FROM settings";
$stmt = $pdo->query($sql);
$setting = $stmt->fetch();

$product_price = 0;

foreach ($products as $product) $product_price += ($product["price"] * $product["quantity"]);

$gst_amount = round($product_price * ($setting["gst"] / 100));

$total_amount = $product_price + $setting["shipping_cost"] + $gst_amount;

$sql = "INSERT INTO orders (status, user_id) VALUES ('Placed', {$_SESSION["id"]})";
$pdo->query($sql);
$order_id = $pdo->lastInsertId();

$sql = "INSERT INTO shipping_addresses (name, mobile, address, order_id) VALUES (:name, :mobile, :address, :order_id)";
$stmt = $pdo->prepare($sql);
$address_details = "{$address["address_line_1"]}, {$address["address_line_2"]}, {$address["city"]}, {$address["state"]}, {$address["pincode"]}";
$stmt->execute([
    "name" => $address["name"],
    "mobile" => $address["mobile"],
    "address" => $address_details,
    "order_id" => $order_id
]);

$sql = "INSERT INTO payment_details (total_amount, gst, gst_amount, product_price, shipping_cost, order_id) VALUES (:total_amount, :gst, :gst_amount, :product_price, :shipping_cost, :order_id)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "total_amount" => $total_amount,
    "product_price" => $product_price,
    "gst_amount" => $gst_amount,
    "shipping_cost" => $setting["shipping_cost"],
    "gst" => $setting["gst"],
    "order_id" => $order_id
]);

foreach ($products as $product) 
{
    $sql = "INSERT INTO ordered_products (name, price, image_url, quantity, order_id) VALUES (:name, :price, :image_url, :quantity, :order_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "name" => $product["name"],
        "price" => $product["price"],
        "image_url" => $product["image_url"],
        "quantity" => $product["quantity"],
        "order_id" => $order_id
    ]);

    if($product["stock"])
    {
        $new_stock = $product["stock"] - $product["quantity"];
        if($new_stock < 0) $new_stock = 0;

        $sql = "UPDATE products SET stock = :stock WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "id" => $product["id"],
            "stock" => $new_stock
        ]);
    }
}

$sql = "DELETE FROM cart WHERE user_id = {$_SESSION["id"]}";
$pdo->query($sql);

$_SESSION["success"] = "Order placed successfully. Your order id is {$order_id}";

header("Location: /index.php");