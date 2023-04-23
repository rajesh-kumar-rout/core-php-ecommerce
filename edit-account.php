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

        <div class="container my-4">
            <?php require("inc/show-flash.php") ?>

            <form class="card mx-auto" action="/update-account.php" method="post" style="max-width:500px">
                <div class="card-header fw-bold text-primary">Edit Account</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input 
                            type="text" 
                            id="name"
                            value="<?= $_SESSION["error"]["name"] ?? $user["name"] ?>"
                            class="form-control <?= isset($_SESSION["errors"]["name"]) ? "is-invalid" : "" ?>" 
                            name="name"
                        >
                        
                        <?php if(isset($_SESSION["errors"]["name"])):  ?>
                            <div class="invalid-feedback"><?= $_SESSION["errors"]["name"] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            type="email" 
                            id="email"
                            value="<?= $_SESSION["error"]["email"] ?? $user["email"] ?>"
                            class="form-control <?= isset($_SESSION["errors"]["email"]) ? "is-invalid" : "" ?>" 
                            name="email"
                        >
                        
                        <?php if(isset($_SESSION["errors"]["email"])):  ?>
                            <div class="invalid-feedback"><?= $_SESSION["errors"]["email"] ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>
            </form>
        </div>

        <?php require("inc/remove-flash.php") ?>
    </body>
</html>