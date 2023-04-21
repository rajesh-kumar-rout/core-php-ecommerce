<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /index.php");
    die();
}

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Create Category</title>
    </head>

    <body>
        <?php require("header.php") ?>

        <h2>Create Category</h2>

        <form action="/admin/store-category.php" method="post">
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
                    <td colspan="2">
                        <button type="submit" name="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
    </body>

    <?php require("footer.php") ?>
</html>