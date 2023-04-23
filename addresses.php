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

    <div class="container my-4">
        <?php require("inc/show-flash.php") ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary">Address</span>
                <a class="btn btn-primary btn-sm" href="/create-address.php">Create New</a>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" style="min-width: 600px">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobie</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($addresses) == 0): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No address added</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach($addresses as $address): ?>
                                <tr>
                                    <td><?= $address["name"] ?></td>
                                    <td><?= $address["mobile"] ?></td>
                                    <td><?= "{$address["address_line_1"]}, {$address["address_line_2"]}, {$address["city"]}, {$address["state"]}, {$address["pincode"]}" ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a class="btn btn-sm btn-warning" href="/edit-address.php?address_id=<?= $address["id"] ?>">Edit</a>

                                            <form action="/delete-address.php" method="post">
                                                <input type="hidden" name="address_id" value="<?= $address["id"] ?>">
                                                <button type="submit" name="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php require("inc/remove-flash.php") ?>
</body>
</html>