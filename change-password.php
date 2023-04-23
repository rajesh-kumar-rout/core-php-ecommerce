<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

?>

<html>
    <head>
        <?php require("inc/head.php") ?>
        <title>Change Password</title>
    </head>
    <body>
        <?php require("inc/navbar.php") ?>

        <div class="container my-4">
            <?php require("inc/show-flash.php") ?>

            <form action="/_change-password.php" method="post" class="card mx-auto" style="max-width:500px">
                <div class="card-header fw-bold text-primary">Change Password</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Old Password</label>
                        <input 
                            type="password" 
                            id="old_password"
                            class="form-control has-validation <?= isset($_SESSION["errors"]["old_password"]) ? "is-invalid" : "" ?>" 
                            name="old_password"
                        >
                        
                        <?php if(isset($_SESSION["errors"]["old_password"])):  ?>
                            <div class="invalid-feedback"><?= $_SESSION["errors"]["old_password"] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        
                        <input 
                            type="password" 
                            id="new_password"
                            class="form-control <?= isset($_SESSION["errors"]["new_password"]) ? "is-invalid" : "" ?>" 
                            name="new_password"
                        >
                        
                        <?php if(isset($_SESSION["errors"]["new_password"])):  ?>
                            <div class="invalid-feedback"><?= $_SESSION["errors"]["new_password"] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                        
                        <input 
                            type="password" 
                            id="confirm_new_password"
                            class="form-control <?= isset($_SESSION["errors"]["confirm_new_password"]) ? "is-invalid" : "" ?>" 
                            name="confirm_new_password"
                        >
                        
                        <?php if(isset($_SESSION["errors"]["confirm_new_password"])):  ?>
                            <div class="invalid-feedback"><?= $_SESSION["errors"]["confirm_new_password"] ?></div>
                        <?php endif; ?>
                    </div>

                    <button class="btn btn-primary w-100">Change Password</button>
                </div>
            </form>
        </div>

        <?php require("inc/remove-flash.php") ?>
    </body>
</html>