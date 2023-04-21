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

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("head.php") ?>
    <title>Categories</title>
</head>
<body>
    <?php require("header.php") ?>

    <a href="/admin/create-category.php">Create Category</a>

    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $category): ?>
                <tr>
                    <td><?= $category["name"] ?></td>
                    <td><?= $category["created_at"] ?></td>
                    <td>
                        <form action="/admin/delete-category.php" method="post">
                            <input type="hidden" name="category_id" value="<?= $category["id"] ?>">
                            <button type="submit" name="submit">Delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="/admin/edit-category.php?category_id=<?= $category["id"] ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php require("footer.php") ?>
</body>
</html>