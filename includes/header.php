<div class="row">
    <div class="col-md-12">
        <div class="float-end mt-2">
            <?php
                // Check if the user is logged in using a cookie
                if (isset($_COOKIE['user'])) {
                    $username = $_COOKIE['user'];
                    $visitCount = isset($_COOKIE['visit']) ? intval($_COOKIE['visit']) : 0;
                    $visitCount++;
                    setcookie("visit", $visitCount, time() + 365 * 24 * 3600, "/"); 
                    if ($visitCount == 1){
                        echo '<p class="text-white">Welcome, ' . $username . '! You have visited the site ' . $visitCount . ' time.</p>';
                    }
                    else {
                        echo '<p class="text-white">Welcome, ' . $username . '! You have visited the site ' . $visitCount . ' times.</p>';
                    }
                    echo '<button class="btn btn-outline-light dropdown-toggle float-end" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">';
                    echo 'User Menu';
                    echo '</button>';
                    echo '<div class="dropdown-menu">';
                    echo '<a class="dropdown-item" href="profile.php">View Profile</a>';
                    echo '<a class="dropdown-item" href="cart.php">Shopping Cart</a>';
                    echo '<div class="dropdown-divider"></div>';
                    echo '<a class="dropdown-item" href="logout.php">Logout</a>';
                    echo '</div>';
                } else {
                    echo '<a href="login.php" class="btn btn-outline-light mr-4"> Login </a>';
                    echo '<a href="cart.php" class="btn btn-outline-light mr-4"> Shopping Cart </a>';
                }
                      
            ?>
        </div>
    </div>
</div>
<header class="top-icon">
    Mini Reads
</header>

