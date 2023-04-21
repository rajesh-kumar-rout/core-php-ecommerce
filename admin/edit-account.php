<?php 

require("db.php");

session_start();

if(!isset($_SESSION["id"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $_SESSION["id"]]);
$user = $stmt->fetch();

?>

<html>
    <head>
        <?php require("head.php") ?>
        <title>Edit Account</title>
    </head>

    <body>
        <?php require("header.php") ?>

        <h2>Edit Account</h2>

        <form action="/admin/update-account.php" method="post">
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

        <?php require("footer.php") ?>
    </body>
</html>