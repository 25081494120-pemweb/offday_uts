<?php
function cleanOutput($value) {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

$friends = require __DIR__ . '/friends-data.php';
$requestedFriend = $_GET['friend'] ?? '';
$activeFriendId = is_string($requestedFriend)
    && isset($friends[$requestedFriend])
        ? $requestedFriend
        : '';
$activeFriend = $activeFriendId !== ''
    ? $friends[$activeFriendId]
    : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Chat — OFFDAY</title>
    <meta name="description"
          content="Mulai percakapan dengan teman di OFFDAY.">
    <link rel="stylesheet" href="Uts%20Nathan.Css">
</head>
<body>
<?php require __DIR__ . '/site-header.php'; ?>

<main class="chat-page">
    <section class="chat-section">
        <div class="chat-page-heading">
            <p class="eyebrow">YOUR CIRCLE, ONE MESSAGE AWAY</p>
            <h1>Ruang <span>chat.</span></h1>
            <p>Percakapan lokal untuk demo OFFDAY.</p>
        </div>

        <div class="chat-notice">
            <span aria-hidden="true">i</span>
            <p>
                Pesan hanya tersimpan di browser ini dan tidak dikirim
                ke temanmu. Untuk chat online sungguhan, situs perlu
                backend, akun pengguna, dan penyimpanan pesan.
            </p>
        </div>

        <div class="chat-layout">
            <aside class="chat-sidebar" aria-label="Daftar percakapan">
                <div class="chat-sidebar-heading">
                    <h2>Teman</h2>
                    <span id="chat-friend-count">0</span>
                </div>
                <p class="chat-empty" id="chat-friends-empty" hidden>
                    Belum ada teman. Tambahkan teman dari halaman Find Friends.
                </p>
                <div class="chat-friend-list">
                    <?php foreach ($friends as $friendId => $friend): ?>
                        <a class="chat-friend-item"
                           href="chat.php?friend=<?= rawurlencode($friendId) ?>"
                           data-chat-friend="<?= cleanOutput($friendId) ?>"
                           aria-current="<?= $activeFriendId === $friendId
                               ? 'page' : 'false' ?>">
                            <img src="images/<?= cleanOutput($friend['image']) ?>"
                                 alt=""
                                 loading="lazy">
                            <span><?= cleanOutput($friend['name']) ?></span>
                            <span class="chat-friend-dot"
                                  aria-hidden="true"></span>
                        </a>
                    <?php endforeach; ?>
                </div>
                <a class="chat-find-friends" href="find-friends.php">
                    Cari teman baru ↗
                </a>
            </aside>

            <section class="chat-room" aria-label="Percakapan">
                <?php if ($activeFriend !== null): ?>
                    <header class="chat-room-header"
                            data-active-friend="<?= cleanOutput($activeFriendId) ?>"
                            data-active-name="<?= cleanOutput($activeFriend['name']) ?>">
                        <img src="images/<?= cleanOutput($activeFriend['image']) ?>"
                             alt="">
                        <div>
                            <h2><?= cleanOutput($activeFriend['name']) ?></h2>
                            <p>Teman OFFDAY</p>
                        </div>
                        <a class="chat-back-link" href="chat.php">
                            Daftar teman
                        </a>
                    </header>
                    <div class="chat-messages" id="chat-messages"
                         aria-live="polite" aria-label="Pesan chat">
                        <div class="chat-placeholder" id="chat-placeholder">
                            <span aria-hidden="true">✳</span>
                            <p>Mulai percakapan dengan
                                <?= cleanOutput($activeFriend['name']) ?>.</p>
                        </div>
                    </div>
                    <form class="chat-compose" id="chat-form">
                        <label class="sr-only" for="chat-input">
                            Tulis pesan
                        </label>
                        <textarea id="chat-input" rows="1" maxlength="1000"
                                  placeholder="Tulis pesan..."
                                  required></textarea>
                        <button type="submit" class="button-primary">
                            Kirim <span aria-hidden="true">↗</span>
                        </button>
                    </form>
                    <p class="chat-status" id="chat-status"
                       role="status" aria-live="polite"></p>
                <?php else: ?>
                    <div class="chat-welcome">
                        <span aria-hidden="true">✳</span>
                        <h2>Pilih teman untuk mulai chat</h2>
                        <p>
                            Tambahkan teman di halaman Find Friends.
                            Temanmu akan muncul di daftar sebelah kiri.
                        </p>
                        <a class="button-primary" href="find-friends.php">
                            Temukan teman ↗
                        </a>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </section>
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

<script src="chat.js" defer></script>
</body>
</html>
