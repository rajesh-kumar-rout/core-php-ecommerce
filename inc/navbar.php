<ul>
    <li>
        <a href="/">Home</a>
    </li>
    <li>
        <a href="/products.php">Products</a>
    </li>
    <li>
        <a href="/search.php">Search</a>
    </li>

    <?php if(isset($_SESSION["email"])): ?>
        <li>
            <a href="/cart.php">Cart</a>
        </li>
        
        <li>
            <a href="/checkout.php">Checkout</a>
        </li>

        <li>
            <span>Account</span>
            <ul>
                <li>
                    <a href="/orders.php">Orders</a>
                </li>
                <li>
                    <a href="/wishlists.php">Wishlists</a>
                </li>
                <li>
                    <a href="/addresses.php">Address</a>
                </li>
                <li>
                    <a href="/change-password.php">Change Password</a>
                </li>
                <li>
                    <a href="/edit-account.php">Edit Account</a>
                </li>
                <li>
                    <a href="/logout.php">Logout</a>
                </li>
            </ul>
        </li>
    <?php else: ?>
        <li>
            <a href="/login.php">Login/Register</a>
        </li>
    <?php endif; ?>
</ul>