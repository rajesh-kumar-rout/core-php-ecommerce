<?php 

session_start();

require("inc/database.php");

require("inc/authenticate.php");

?>

<html>
<head>
    <?php require("inc/head.php") ?>
    <title>Create New Address</title>
</head>

<body>
    <?php require("inc/navbar.php") ?>

    <div class="container my-4">
        <?php require("inc/show-flash.php") ?>

        <form class="card mx-auto" style="max-width:600px" action="/store-address.php" method="post">
            <div class="card-header fw-bold text-primary">Create New Address</div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input 
                        type="text" 
                        id="name"
                        class="form-control <?= isset($_SESSION["errors"]["name"]) ? "is-invalid" : "" ?>" 
                        name="name"
                        value="<?= $_SESSION["data"]["name"] ?? "" ?>"
                    >
                    
                    <?php if(isset($_SESSION["errors"]["name"])):  ?>
                        <div class="invalid-feedback"><?= $_SESSION["errors"]["name"] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input 
                        type="number" 
                        id="mobile"
                        class="form-control <?= isset($_SESSION["errors"]["mobile"]) ? "is-invalid" : "" ?>" 
                        name="mobile"
                        value="<?= $_SESSION["data"]["mobile"] ?? "" ?>"
                    >
                    
                    <?php if(isset($_SESSION["errors"]["mobile"])):  ?>
                        <div class="invalid-feedback"><?= $_SESSION["errors"]["mobile"] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="address_line_1" class="form-label">Address line 1</label>
                    <input 
                        type="text" 
                        id="address_line_1"
                        class="form-control <?= isset($_SESSION["errors"]["address_line_1"]) ? "is-invalid" : "" ?>" 
                        name="address_line_1"
                        value="<?= $_SESSION["data"]["address_line_1"] ?? "" ?>"
                    >
                    
                    <?php if(isset($_SESSION["errors"]["address_line_1"])):  ?>
                        <div class="invalid-feedback"><?= $_SESSION["errors"]["address_line_1"] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="address_line_2" class="form-label">Address line 2</label>
                    <input 
                        type="text" 
                        id="address_line_2"
                        class="form-control <?= isset($_SESSION["errors"]["address_line_2"]) ? "is-invalid" : "" ?>" 
                        name="address_line_2"
                        value="<?= $_SESSION["data"]["address_line_2"] ?? "" ?>"
                    >
                    
                    <?php if(isset($_SESSION["errors"]["address_line_2"])):  ?>
                        <div class="invalid-feedback"><?= $_SESSION["errors"]["address_line_2"] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input 
                        type="text" 
                        id="city"
                        class="form-control <?= isset($_SESSION["errors"]["city"]) ? "is-invalid" : "" ?>" 
                        name="city"
                        value="<?= $_SESSION["data"]["city"] ?? "" ?>"
                    >
                    
                    <?php if(isset($_SESSION["errors"]["city"])):  ?>
                        <div class="invalid-feedback"><?= $_SESSION["errors"]["city"] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="state" class="form-label">State</label>
                    <input 
                        type="text" 
                        id="state"
                        class="form-control <?= isset($_SESSION["errors"]["state"]) ? "is-invalid" : "" ?>" 
                        name="state"
                        value="<?= $_SESSION["data"]["state"] ?? "" ?>"
                    >
                    
                    <?php if(isset($_SESSION["errors"]["state"])):  ?>
                        <div class="invalid-feedback"><?= $_SESSION["errors"]["state"] ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="pincode" class="form-label">Pincode</label>
                    <input 
                        type="number" 
                        id="pincode"
                        class="form-control <?= isset($_SESSION["errors"]["pincode"]) ? "is-invalid" : "" ?>" 
                        name="pincode"
                        value="<?= $_SESSION["data"]["pincode"] ?? "" ?>"
                    >
                    
                    <?php if(isset($_SESSION["errors"]["pincode"])):  ?>
                        <div class="invalid-feedback"><?= $_SESSION["errors"]["pincode"] ?></div>
                    <?php endif; ?>
                </div>

                <button class="btn btn-primary w-100" type="submit">Save</button>
            </div>
        </form>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>
</html>