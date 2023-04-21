<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /index.php");
    die();
}

$sql = "SELECT products.*, categories.name as category_name FROM products INNER JOIN categories ON categories.id = products.category_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("head.php") ?>
    <title>Products</title>
</head>
<body>
    <?php require("header.php") ?>

    <a href="/admin/create-product.php">Create Products</a>

    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Image</td>
                <td>Active</td>
                <td>Stock</td>
                <td>Price</td>
                <td>Category</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td><?= $product["name"] ?></td>
                    <td>
                        <img height="60px" width="60px" src="/<?= $product["image_url"] ?>" alt="">
                    </td>
                    <td>
                        <?= $product["is_active"] ? "yes" : "no" ?>
                    </td>
                    <td>
                        <?= $product["stock"]  ?>
                    </td>
                    <td>
                        <?= $product["price"]  ?>
                    </td>
                    <td>
                        <?= $product["category_name"]  ?>
                    </td>
                    <td>
                        <?= $product["created_at"]  ?>
                    </td>
                    <td>
                        <form action="/admin/delete-product.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                            <button type="submit" name="submit">Delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="/admin/edit-product.php?product_id=<?= $product["id"] ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php require("footer.php") ?>
</body>
</html>