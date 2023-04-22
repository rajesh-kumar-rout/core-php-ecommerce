<?php 

require("admin/db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT * FROM cart INNER JOIN products ON cart.product_id = products.id AND (products.stock IS NULL OR products.stock > cart.quantity) WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(["user_id" => $_SESSION["id"]]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM settings";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$setting = $stmt->fetch(PDO::FETCH_ASSOC);

$product_price = 0;

foreach ($products as $product) $product_price += ($product["price"] * $product["quantity"]);

$gst_amount = round($product_price * ($setting["gst"] / 100));

$total_amount = $product_price + $setting["shipping_cost"] + $gst_amount;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
</head>
<body>
<?php if(isset($_SESSION["success"])): ?>
    <p><?php echo $_SESSION["success"]; ?></p>
<?php endif; ?>

<?php if(isset($_SESSION["error"])): ?>
    <p><?php echo $_SESSION["error"]; ?></p>
<?php endif; ?>

    <table>
        <thead>
            <tr>
                <td>Product</td>
                <td>Quantity</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td>
                        <div>
                            <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
                            <span><?= $product["name"] ?></span>
                        </div>
                    </td>
                    <td>
                        <form action="/create-cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                            <input type="number" name="quantity" value="<?= $product["quantity"] ?>">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="/delete-cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <p>Product Price : <?= $product_price ?></p>
    <p>Gst : <?= $setting["gst"] ?></p>
    <p>Gst Amount : <?= $gst_amount ?></p>
    <p>Shipping Cost : <?= $setting["shipping_cost"] ?></p>
    <p>Total Amount : <?= $total_amount ?></p>
    <?php 
    if(isset($_SESSION["data"])) unset($_SESSION["data"]) ;

    if(isset($_SESSION["success"])) unset($_SESSION["success"]) ;

    if(isset($_SESSION["error"])) unset($_SESSION["error"]) ;
?>
</body>
</html>