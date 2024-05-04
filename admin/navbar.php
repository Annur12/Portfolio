<nav class="navbar navbar-expand-md navbar-light shadow-sm">
    <div class="container-xl">
        <a href="dashboard.php" class="navbar-brand">
            <span class="fw-bold text-secondary"><i class="bi bi-alexa"></i></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end align-center" id="main-nav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo $_SESSION['username']; // Display the username
                        } else {
                            echo "Username"; // Default text if username is not set
                        }
                        ?>
                    </a>
                    <ul class="dropdown-menu mt-2">
                        <li><a href="edit_account.php" class="dropdown-item">Edit Account</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Sign Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>