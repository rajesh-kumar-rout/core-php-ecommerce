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

    <div class="container my-4">
        <div class="carousel slider">
            <?php foreach($sliders as $slider): ?>
                <div class="carousel inner">
                    <div class="carousel item">
                        <img src="<?= $slider["image_url"] ?>" class="w-100 d-block">
                    </div>
                </div>
                <div class="carousel-control-prev" data-bs-slider="prev" data-bs-target=".carousel">
                    <span class="carousel-control-prev-icon"></span>
                </div>
                <div class="carousel-control-next" data-bs-slider="next" data-bs-target=".carousel">
                    <div class="carousel-control-next-icon"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php foreach($data as $item): ?>
            <div class="mt-4">
                <h4 class="fw-bold text-primary border-bottom border-primary pb-2 mb-3"><?= $item["name"] ?></h4>
                
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
                    <?php foreach($item["products"] as $product): ?>
                        <a class="text-dark text-center text-decoration-none" href="/details.php?product_id=<?= $product["id"] ?>">
                            <img class="img-fluid" src="<?= $product["image_url"] ?>" alt="">
                            <p class="fw-bold mt-2 mb-1"><?= $product["name"] ?></p>
                            <p class="fw-bold text-primary">Rs. <?= $product["price"] ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>

</html>