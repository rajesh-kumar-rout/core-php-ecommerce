<div class="navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: tomato; color: white">
    <div class="container">
        <a href="/" class="navbar-brand">Ecommerce</a>

        <button class="navbar-toggler" data-bs-target="#navContent" data-bs-toggle="collapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/search.php">Search</a>
                </li>

                <?php if(isset($_SESSION["email"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/cart.php">Cart</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/checkout.php">Checkout</a>
                    </li>

                    <li class="nav-item dropdown" data-bs-theme="light">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account</a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="/orders.php">Orders</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/wishlists.php">Wishlists</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/addresses.php">Address</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/change-password.php">Change Password</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/edit-account.php">Edit Account</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/logout.php">Logout</a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>