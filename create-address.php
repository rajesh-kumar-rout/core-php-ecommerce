<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

?>

<html>
    <head>
        <?php require("inc/head.php") ?>
        <title>Create Address</title>
    </head>

    <body>
        <?php require("inc/navbar.php") ?>

        <?php require("inc/show-flash.php") ?>

        <h2>Create Address</h2>

        <form action="/store-address.php" method="post">
            <table>
                <tr>
                    <td>
                        <label for="name">Name</label>
                    </td>
                    <td>
                        <input type="text" required name="name" maxlength="50" value="<?= isset($_SESSION["data"]["name"]) ? $_SESSION["data"]["name"] : ""  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="mobile">Mobile</label>
                    </td>
                    <td>
                        <input type="number" required name="mobile" maxlength="50" value="<?= isset($_SESSION["data"]["mobile"]) ? $_SESSION["data"]["mobile"] : ""  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="address_line_1">Address Line 1</label>
                    </td>
                    <td>
                        <input type="text" required name="address_line_1" maxlength="50" value="<?= isset($_SESSION["data"]["address_line_1"]) ? $_SESSION["data"]["address_line_1"] : ""  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="address_line_2">Address Line 2</label>
                    </td>
                    <td>
                        <input type="text" required name="address_line_2" maxlength="50" value="<?= isset($_SESSION["data"]["address_line_2"]) ? $_SESSION["data"]["address_line_2"] : ""  ?>">
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <label for="city">City</label>
                    </td>
                    <td>
                        <input type="text" required name="city" maxlength="50" value="<?= isset($_SESSION["data"]["city"]) ? $_SESSION["data"]["city"] : ""  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="state">State</label>
                    </td>
                    <td>
                        <input type="text" required name="state" maxlength="50" value="<?= isset($_SESSION["data"]["state"]) ? $_SESSION["data"]["state"] : ""  ?>">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="pincode">Pincode</label>
                    </td>
                    <td>
                        <input type="number" required name="pincode" maxlength="50" value="<?= isset($_SESSION["data"]["pincode"]) ? $_SESSION["data"]["pincode"] : ""  ?>">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <button type="submit" name="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>

        <?php require("inc/remove-flash.php") ?>
    </body>
</html>