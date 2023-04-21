<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT * FROM settings LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$setting = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Edit Setting</title>
    </head>

    <body>
        <?php require("header.php") ?>

        <h2>Edit Setting</h2>

        <form action="/admin/update-settings.php" method="post">
            <table>
                <tr>
                    <td>
                        <label for="shipping_cost">Shipping Cost</label>
                    </td>
                    <td>
                        <input type="number" required name="shipping_cost" value="<?= isset($_SESSION["data"]["shipping_cost"]) ? $_SESSION["data"]["shipping_cost"] : $setting["shipping_cost"]  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="gst">Gst</label>
                    </td>
                    <td>
                        <input type="number" required name="gst" value="<?= isset($_SESSION["data"]["gst"]) ? $_SESSION["data"]["gst"] : $setting["shipping_cost"]  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="email">Email</label>
                    </td>
                    <td>
                        <input type="text" required name="email" value="<?= isset($_SESSION["data"]["email"]) ? $_SESSION["data"]["email"] : $setting["email"]  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="return_address">Return Address</label>
                    </td>
                    <td>
                        <input type="text" required name="return_address" value="<?= isset($_SESSION["data"]["return_address"]) ? $_SESSION["data"]["return_address"] : $setting["return_address"]  ?>">
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