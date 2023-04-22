<?php 

require("admin/db.php");
require("functions.php");

session_start();

authenticate();

$sql = "SELECT * FROM addresses WHERE user_id = :user_id AND id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "user_id" => $_SESSION["id"],
    "id" => $_GET["address_id"],
]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<html>
    <head>
        <?php require("header.php") ?>
        <title>Edit Address</title>
    </head>

    <body>
        <?php require("navbar.php") ?>

        <?php require("flash-alert.php") ?>

        <h2>Edit Address</h2>

        <form action="/update-address.php" method="post">
            <input type="hidden" name="id" value="<?= $address["id"] ?>">
            <table>
                <tr>
                    <td>
                        <label for="name">Name</label>
                    </td>
                    <td>
                        <input type="text" required name="name" maxlength="50" value="<?= isset($_SESSION["data"]["name"]) ? $_SESSION["data"]["name"] : $address["name"]  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="mobile">Mobile</label>
                    </td>
                    <td>
                        <input type="number" required name="mobile" maxlength="50" value="<?= isset($_SESSION["data"]["mobile"]) ? $_SESSION["data"]["mobile"] : $address["mobile"]  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="address_line_1">Address Line 1</label>
                    </td>
                    <td>
                        <input type="text" required name="address_line_1" maxlength="50" value="<?= isset($_SESSION["data"]["address_line_1"]) ? $_SESSION["data"]["address_line_1"] : $address["address_line_1"] ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="address_line_2">Address Line 2</label>
                    </td>
                    <td>
                        <input type="text" required name="address_line_2" maxlength="50" value="<?= isset($_SESSION["data"]["address_line_2"]) ? $_SESSION["data"]["address_line_2"] : $address["address_line_2"]  ?>">
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <label for="city">City</label>
                    </td>
                    <td>
                        <input type="text" required name="city" maxlength="50" value="<?= isset($_SESSION["data"]["city"]) ? $_SESSION["data"]["city"] : $address["city"]  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="state">State</label>
                    </td>
                    <td>
                        <input type="text" required name="state" maxlength="50" value="<?= isset($_SESSION["data"]["state"]) ? $_SESSION["data"]["state"] : $address["state"]  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="pincode">Pincode</label>
                    </td>
                    <td>
                        <input type="number" required name="pincode" maxlength="50" value="<?= isset($_SESSION["data"]["pincode"]) ? $_SESSION["data"]["pincode"] : $address["pincode"]  ?>">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <button type="submit" name="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
        
        <?php require("remove-flash.php") ?>
    </body>
</html>