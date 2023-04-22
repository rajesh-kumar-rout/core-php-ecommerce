<?php

require("admin/db.php");

$sql = "SELECT * FROM sliders";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM categories";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM products WHERE is_active = 1";

if(isset($_GET["category_id"])) $sql .= " AND category_id = :category_id";

$stmt = $pdo->prepare($sql);

if(isset($_GET["category_id"])) $stmt->execute(["category_id" => $_GET["category_id"]]);
else $stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>

    <?php foreach($categories as $category): ?>
        <a href="/products.php?category_id=<?= $category["id"] ?>"><?= $category["name"] ?></a>
    <?php endforeach; ?>

    <?php foreach($products as $product): ?>
        <div>
            <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
            <h4><?= $product["name"] ?></h4>
            <p><?= $product["price"] ?></p>
        </div>
    <?php endforeach; ?>

</body>
</html>