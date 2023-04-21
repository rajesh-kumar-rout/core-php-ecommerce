<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: login.php");
    die();
}

$sql = "SELECT * FROM settings LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$setting = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("head.php") ?>
    <title>Settings</title>
</head>
<body>
    <?php require("header.php") ?>

    <a href="/admin/edit-settings.php">Edit Setting</a>

    <table>
        <thead>
            <tr>
                <td>Shipping Cost</td>
                <td>Gst</td>
                <td>Return Address</td>
                <td>Email</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $setting["shipping_cost"] ?></td>
                <td><?= $setting["gst"] ?></td>
                <td><?= $setting["return_address"] ?></td>
                <td><?= $setting["email"] ?></td>
            </tr>
        </tbody>
    </table>

    <?php require("footer.php") ?>
</body>
</html>