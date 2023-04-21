<?php 

require("db.php");

session_start();

if(isset($_SESSION["email"]))
{
    header("Location: /index.php");
    die();
}

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Login</title>
    </head>
    <body>
        <?php if(isset($_SESSION["success"])): ?>
            <p><?= $_SESSION["success"]; ?></p>
        <?php endif; ?>

        <?php if(isset($_SESSION["error"])): ?>
            <p><?= $_SESSION["error"]; ?></p>
        <?php endif; ?>


        <h2>Login</h2>

        <form action="do-login.php" method="post">
            <table>
                <tr>
                    <td>
                        <label for="email">Email</label>
                    </td>
                    <td>
                        <input type="email" name="email" required maxlength="40" value="<?php echo isset($_SESSION["data"]["email"]) ? $_SESSION["data"]["email"] : "" ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password</label>
                    </td>
                    <td>
                        <input type="password" name="password" required minlength="6" maxlength="20">
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