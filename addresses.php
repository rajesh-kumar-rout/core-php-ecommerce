<?php 

require("admin/db.php");
require("functions.php");

session_start();

authenticate();

$sql = "SELECT * FROM addresses WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(["user_id" => $_SESSION["id"]]);
$addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("header.php") ?>
    <title>Address</title>
</head>
<body>
    <?php require("navbar.php") ?>

    <?php require("flash-alert.php") ?>

    <a href="/create-address.php">Create</a>

    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Mobie</td>
                <td>Address</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($addresses as $address): ?>
                <tr>
                    <td><?= $address["name"] ?></td>
                    <td><?= $address["mobile"] ?></td>
                    <td><?= "{$address["address_line_1"]}, {$address["address_line_2"]}, {$address["city"]}, {$address["state"]}, {$address["pincode"]}" ?></td>
                    <td>
                        <a href="/edit-address.php?address_id=<?= $address["id"] ?>">Edit</a>

                        <form action="/delete-address.php" method="post">
                            <input type="hidden" name="address_id" value="<?= $address["id"] ?>">
                            <button type="submit" name="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php require("remove-flash.php") ?>
</body>
</html>