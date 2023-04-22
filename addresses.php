<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

$sql = "SELECT * FROM addresses WHERE user_id = {$_SESSION["id"]}";
$stmt = $pdo->query($sql);
$addresses = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Address</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <?php require("inc/show-flash.php") ?>

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

    <?php require("inc/remove-flash.php") ?>
</body>
</html>