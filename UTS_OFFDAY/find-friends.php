<?php
function cleanOutput($value) {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

$friends = require __DIR__ . '/friends-data.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Find Your People — OFFDAY</title>
    <meta name="description"
          content="Lihat profil komunitas OFFDAY, cari teman, dan kelola daftar temanmu.">
    <link rel="stylesheet" href="Uts%20Nathan.Css">
</head>
<body>
<?php require __DIR__ . '/site-header.php'; ?>

<main>
    <?php require __DIR__ . '/friends-section.php'; ?>
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

<script src="friends.js" defer></script>
</body>
</html>
