<?php 

session_start();

require("inc/database.php");

require("inc/un-authenticate.php");

?>

<html>
<head>
    <?php require("inc/head.php") ?>
    <title>Register</title>
    <style>
        .has-error{
            border: 1px solid red;
        }
    </style>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <div class="container my-4">
        <?php require("inc/show-flash.php") ?>

        <form class="mx-auto p-4 border" action="/_register.php" method="post" style="max-width:500px">
            <h4 class="mb-4 text-primary fw-bold text-center">Register</h4>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    id="name"
                    value="<?= $_SESSION["data"]["name"] ?? "" ?>"
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
                    type="text" 
                    id="email"
                    value="<?= $_SESSION["data"]["email"] ?? "" ?>"
                    class="form-control <?= isset($_SESSION["errors"]["email"]) ? "is-invalid" : "" ?>" 
                    name="email"
                >
                
                <?php if(isset($_SESSION["errors"]["email"])):  ?>
                    <div class="invalid-feedback"><?= $_SESSION["errors"]["email"] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password"
                    class="form-control <?= isset($_SESSION["errors"]["password"]) ? "is-invalid" : "" ?>" 
                    name="password"
                >
                
                <?php if(isset($_SESSION["errors"]["password"])):  ?>
                    <div class="invalid-feedback"><?= $_SESSION["errors"]["password"] ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>