<?php if(isset($_SESSION["success"])): ?>
    <p><?php echo $_SESSION["success"]; ?></p>
<?php endif; ?>

<?php if(isset($_SESSION["error"])): ?>
    <p><?php echo $_SESSION["error"]; ?></p>
<?php endif; ?>
