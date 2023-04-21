<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Create slider</title>
    </head>
    <body>
        <?php require("header.php") ?>

        <h2>Create slider</h2>
        
        <form action="/admin/store-slider.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <label for="image">Image</label>
                    </td>
                    <td>
                        <input type="file" required name="image" >
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" name="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>

        <?php require("footer.php") ?>
    </body>
</html>