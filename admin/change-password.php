<?php 

require("db.php");

session_start();

if(!isset($_SESSION["id"]))
{
    header("Location: /admin/login.php");
    die();
}

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Change Password</title>
    </head>
    <body>
        <?php require("header.php") ?>

        <h2>Change Password</h2>

        <form action="/admin/do-change-password.php" method="post">
            <table>
                <tr>
                    <td>
                        <label for="old_password">Old Password</label>
                    </td>
                    <td>
                        <input type="password" required maxlength="20" name="old_password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="new_password">New Password</label>
                    </td>
                    <td>
                        <input type="password" required maxlength="20" name="new_password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="new_password">Confirm New Password</label>
                    </td>
                    <td>
                        <input type="password" required maxlength="20" name="confirm_new_password">
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