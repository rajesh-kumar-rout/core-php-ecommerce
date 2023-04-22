<?php

session_start();

require("inc/database.php");

$sql = "SELECT * FROM sliders";
$stmt = $pdo->query($sql);
$sliders = $stmt->fetchAll();

$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();

$sql = "SELECT * FROM products WHERE is_active = 1";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();

$removed_indexes = [];

for ($i = 0; $i < count($categories); $i++)
{
    $categories[$i]["products"] = [];

    for ($j = 0; $j < count($products); $j++)
    {
        if($products[$j]["category_id"] == $categories[$i]["id"]) array_push($categories[$i]["products"], $products[$j]);
    }

    if(count($categories[$i]["products"]) == 0) array_push($removed_indexes, $i);
}

$data = [];

for ($i = 0; $i < count($categories); $i++) if(!in_array($i, $removed_indexes)) array_push($data, $categories[$i]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Home</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <?php require("inc/show-flash.php") ?>

    <?php foreach($sliders as $slider): ?>
        <img height="60px" width="60px" src="<?= $slider["image_url"] ?>" alt="">
    <?php endforeach; ?>

    <?php foreach($data as $item): ?>
        <div>
            <h2><?= $item["name"] ?></h2>
            <?php foreach($item["products"] as $product): ?>
                <a href="/details.php?product_id=<?= $product["id"] ?>">
                    <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
                    <h4><?= $product["name"] ?></h4>
                    <p><?= $product["price"] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>