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
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$removed_indexes = [];

for ($i = 0; $i < count($categories); $i++)
{
    $categories[$i]["products"] = [];

    for ($j = 0; $j < count($products); $j++)
    {
        if($products[$j]["category_id"] == $categories[$i]["id"])
        {
            array_push($categories[$i]["products"], $products[$j]);
        }
    }

    if(count($categories[$i]["products"]) == 0) array_push($removed_indexes, $i);
}

$data = [];

for ($i = 0; $i < count($categories); $i++)
{
    if(!in_array($i, $removed_indexes)) array_push($data, $categories[$i]);
}

// echo "<pre>";
// print_r($data);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

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

</body>
</html>