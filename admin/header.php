<ul>
    <li>
        <a href="/admin">Dashboard</a>
    </li>
    <li>
        <a href="/admin/sliders.php">Slider</a>
    </li>
    <li>
        <a href="/admin/categories.php">Category</a>
    </li>
    <li>
        <a href="/admin/products.php">Product</a>
    </li>
    <li>
        <a href="/admin/orders.php">Orders</a>
    </li>
    <li>
        <a href="/admin/reviews.php">Reviews</a>
    </li>
    <li>
        <a href="/admin/customers.php">Customers</a>
    </li>
    <li>
        <a href="/admin/settings.php">Settings</a>
    </li>
    <li>
        <a href="/admin/edit-account.php">Edit Account</a>
    </li>
    <li>
        <a href="/admin/change-password.php">Change Password</a>
    </li>
    <li>
        <a href="/admin/logout.php">Logout</a>
    </li>
</ul>

<?php if(isset($_SESSION["success"])): ?>
    <p><?php echo $_SESSION["success"]; ?></p>
<?php endif; ?>

<?php if(isset($_SESSION["error"])): ?>
    <p><?php echo $_SESSION["error"]; ?></p>
<?php endif; ?>
