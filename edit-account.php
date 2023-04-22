<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM users WHERE id = {$_SESSION["id"]} LIMIT 1";
$stmt = $pdo->query($sql);
$user = $stmt->fetch();

?>

<html>
    <head>
        <?php require("inc/head.php") ?>
        <title>Edit Account</title>
    </head>

    <body>
        <?php require("inc/navbar.php") ?>

        <?php require("inc/show-flash.php") ?>

        <h2>Edit Account</h2>

        <form action="/update-account.php" method="post">
            <table>
                <tr>
                    <td>
                        <label for="name">Name</label>
                    </td>
                    <td>
                        <input type="text" required maxlength="20" name="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : $user["name"] ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email</label>
                    </td>
                    <td>
                        <input type="email" required maxlength="20" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : $user["email"] ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" name="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>

        <?php require("inc/show-flash.php") ?>
    </body>
</html>