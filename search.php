<?php

require("admin/db.php");

$sql = "SELECT * FROM products WHERE is_active = 1 AND (`name` LIKE :search OR `description` LIKE :search)";
$stmt = $pdo->prepare($sql);

$search = isset($_GET["search"]) ? $_GET["search"] :  "";

$search = "%{$search}%";

$stmt->bindParam(":search", $search, PDO::PARAM_STR);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products</title>
</head>
<body>

    <form action="" method="get">
        <input type="search" value="<?= $_GET["search"] ?? "" ?>" name="search" id="search">
        <button type="submit">Search</button>
    </form>

    <?php foreach($products as $product): ?>
        <div>
            <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
            <h4><?= $product["name"] ?></h4>
            <p><?= $product["price"] ?></p>
        </div>
    <?php endforeach; ?>

</body>
</html>