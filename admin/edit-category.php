<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT * FROM categories WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_GET["category_id"]]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Edit Category</title>
    </head>

    <body>
        <?php require("header.php") ?>

        <h2>Edit Category</h2>

        <form action="/admin/update-category.php" method="post">
            <input type="hidden" name="category_id" value="<?= $category["id"] ?>">
            <table>
                <tr>
                    <td>
                        <label for="name">Name</label>
                    </td>
                    <td>
                        <input type="text" required name="name" maxlength="20" value="<?= isset($_SESSION["data"]["name"]) ? $_SESSION["data"]["name"] : $category["name"]  ?>">
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