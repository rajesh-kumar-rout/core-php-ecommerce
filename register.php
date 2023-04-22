<?php 

session_start();

require("inc/database.php");

require("inc/un-authenticate.php");

?>

<html>
<head>
    <?php require("inc/head.php") ?>
    <title>Register</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <?php require("inc/show-flash.php") ?>

    <h2>Register</h2>

    <form action="/_register.php" method="post">
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

    <?php require("inc/remove-flash.php") ?>
</body>
</html>