<?php

require("admin/db.php");

session_start();

$sql = "SELECT * FROM wishlists INNER JOIN products ON products.id = wishlists.product_id WHERE user_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_SESSION["id"]]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlists</title>
</head>
<body>

    <?php foreach($products as $product): ?>
        <a href="/details.php?product_id=<?= $product["id"] ?>">
            <img height="60px" width="60px" src="<?= $product["image_url"] ?>" alt="">
            <h4><?= $product["name"] ?></h4>
            <p><?= $product["price"] ?></p>
            <form action="/delete-wishlist.php" method="post">
                <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                <button type="submit">Remove</button>
            </form>
        </a>
    <?php endforeach; ?>

</body>
</html>