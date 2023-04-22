<?php

require("admin/db.php");

session_start();

$sql = "SELECT * FROM products WHERE is_active = 1 AND id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "id" => $_GET["product_id"]
]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM products WHERE is_active = 1 AND category_id = :category_id AND id != :id LIMIT 20";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "category_id" => $product["category_id"],
    "id" => $product["id"]
]);
$related = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT reviews.*, users.name as user FROM reviews INNER JOIN users ON users.id = reviews.user_id WHERE reviews.product_id = :product_id AND reviews.is_approved = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "product_id" => $product["id"]
]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);


// echo "<pre>";
// print_r($reviews);
// echo "</pre>";
// die;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
</head>
<body>
<?php if(isset($_SESSION["success"])): ?>
    <p><?php echo $_SESSION["success"]; ?></p>
<?php endif; ?>

<?php if(isset($_SESSION["error"])): ?>
    <p><?php echo $_SESSION["error"]; ?></p>
<?php endif; ?>

        <div>
            <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
            <h4><?= $product["name"] ?></h4>
            <p><?= $product["price"] ?></p>
            <form action="/create-cart.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                <input type="number" name="quantity" id="quantity">
                <button type="submit">Add to cart</button>
            </form>
            <form action="/create-wishlist.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                <button type="submit">Wishlist</button>  
            </form>
        </div>

        <?php foreach($related as $product): ?>
            <a href="/details.php?product_id=<?= $product["id"] ?>">
                <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
                <h4><?= $product["name"] ?></h4>
                <p><?= $product["price"] ?></p>
            </a>
        <?php endforeach; ?>

        <h2><?= count($reviews) ?></h2>

        <?php foreach($reviews as $review): ?>
            <div>
                <h4><?= $review["review"] ?></h4>
                <p><?= $review["user"] ?></p>
                <p><?= $review["created_at"] ?></p>
            </div>
        <?php endforeach; ?>

        <?php 
    if(isset($_SESSION["data"])) unset($_SESSION["data"]) ;

    if(isset($_SESSION["success"])) unset($_SESSION["success"]) ;

    if(isset($_SESSION["error"])) unset($_SESSION["error"]) ;
?>
</body>
</html>