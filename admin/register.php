<?php 

require("db.php");

session_start();

if(isset($_SESSION["email"]))
{
    header("Location: index.php");
    die();
}

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Register</title>
    </head>
    <body>
        <?php if(isset($_SESSION["success"])): ?>
            <p><?php echo $_SESSION["success"]; ?></p>
        <?php endif; ?>

        <?php if(isset($_SESSION["error"])): ?>
            <p><?php echo $_SESSION["error"]; ?></p>
        <?php endif; ?>

        <h2>Register</h2>

        <form action="do-register.php" method="post">
            <table>
                <tr>
                    <td>
                        <label for="name">Name</label>
                    </td>
                    <td>
                        <input type="text" required maxlength="20" name="name" value="<?php echo isset($_SESSION["data"]["name"]) ? $_SESSION["data"]["name"] : "" ?>">
                    </td>
                </tr>
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