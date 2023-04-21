<?php 
require("db.php");
session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT * FROM categories";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Create Product</title>
    </head>
    <body>
        <?php require("header.php") ?>

        <h2>Create Product</h2>

        <form action="/admin/store-product.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <label for="name">Name</label>
                    </td>
                    <td>
                        <input type="text" required name="name" maxlength="20" value="<?= isset($_SESSION["data"]["name"]) ? $_SESSION["data"]["name"] : ""  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="price">Price</label>
                    </td>
                    <td>
                        <input type="number" required name="price" value="<?= isset($_SESSION["data"]["price"]) ? $_SESSION["data"]["price"] : ""  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="stock">Stock</label>
                    </td>
                    <td>
                        <input type="number" required name="stock" value="<?= isset($_SESSION["data"]["stock"]) ? $_SESSION["data"]["stock"] : ""  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input id="is_active" type="checkbox" name="is_active" <?= isset($_SESSION["data"]["is_active"]) ? "checked" : ""  ?>>
                    </td>
                    <td>
                        <label for="is_active">Active</label>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="category_id">Category</label>
                    </td>
                    <td>
                        <select name="category_id" id="category_id">
                            <?php foreach($categories as $category): ?>
                                <option <?= isset($_SESSION["data"]["category_id"]) && $_SESSION["data"]["category_id"] == $category["id"] ? "selected" : "" ?> value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="description">Description</label>
                    </td>
                    <td>
                        <textarea name="description" id="description"><?= isset($_SESSION["data"]["description"]) ? $_SESSION["data"]["description"] : ""  ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="image">Image</label>
                    </td>
                    <td>
                        <input type="file" name="image" id="image" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <button type="submit" name="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
    </body>

    <?php require("footer.php") ?>
</html>