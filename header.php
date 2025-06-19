<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EcoGuardian</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="header.css"> <!-- We’ll create this next -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header class="eco-header">
        <div class="logo-title">
            <img src="images/logo.png" alt="EcoGuardian Logo" class="logo">
            <h1>EcoGuardian</h1>
        </div>
        <?php if (isset($_SESSION['user'])): ?>
            <div class="user-info">
                <div class="user-icon" onclick="toggleDropdown()">
                    <i class="fas fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                    <i class="fas fa-caret-down"></i>
                </div>
                <div id="user-dropdown" class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="rewards.html">Rewards</a>
                    <a href="community.html">Community</a>
                    <a href="report.html">Report Issue</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="auth-links">
                <a href="login.html">Login</a>
                <a href="register.html">Register</a>
            </div>
        <?php endif; ?>
    </header>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('user-dropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.closest('.user-icon')) {
                const dropdown = document.getElementById('user-dropdown');
                if (dropdown) dropdown.classList.remove('show');
            }
        };
    </script>
</body>
</html>
