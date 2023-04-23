<?php if(isset($_SESSION["success"])): ?>
    <div class="alert alert-success mb-3"><?= $_SESSION["success"]; ?></div>
<?php endif; ?>

<?php if(isset($_SESSION["error"])): ?>
    <div class="alert alert-danger mb-3"><?= $_SESSION["error"]; ?></div>
<?php endif; ?>
