<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<header class="navbar">
    <a href="Uts%20Nathan.php#home" class="logo">
        OFF<span>DAY</span>
        <span class="logo-dot"></span>
    </a>

    <nav class="nav-links">
        <a href="Uts%20Nathan.php#home">Home</a>
        <a href="Uts%20Nathan.php#about">About</a>
        <a href="communities.php"
           <?= $currentPage === 'communities.php'
               ? 'aria-current="page"' : '' ?>>Communities</a>
        <a href="premium.php"
           <?= $currentPage === 'premium.php'
               ? 'aria-current="page"' : '' ?>>Premium</a>
        <a href="find-friends.php"
           <?= $currentPage === 'find-friends.php'
               ? 'aria-current="page"' : '' ?>>Find Friends</a>
        <a href="chat.php"
           <?= $currentPage === 'chat.php'
               ? 'aria-current="page"' : '' ?>>Chat</a>
        <a href="Uts%20Nathan.php#how-it-works">How It Works</a>
        <a href="Uts%20Nathan.php#contact">Contact Us</a>
    </nav>

    <a href="find-friends.php" class="nav-button">Find Your People ↗</a>
</header>
