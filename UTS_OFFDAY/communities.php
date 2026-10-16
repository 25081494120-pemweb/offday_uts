<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Explore Communities — OFFDAY</title>
    <meta name="description"
          content="Jelajahi komunitas OFFDAY dan temukan aktivitas yang kamu sukai.">
    <link rel="stylesheet" href="Uts%20Nathan.Css">
</head>
<body>
<?php require __DIR__ . '/site-header.php'; ?>

<main>
    <?php require __DIR__ . '/communities-section.php'; ?>
</main>

<footer class="footer">
    <a href="Uts%20Nathan.php#home" class="logo footer-logo">
        OFF<span>DAY</span><span class="logo-dot"></span>
    </a>
    <p>Your people. Your kind of day.</p>
    <p class="copyright">
        &copy; <?= date('Y') ?> OFFDAY. Made for better days.
    </p>
</footer>
</body>
</html>
