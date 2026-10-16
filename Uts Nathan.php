<?php
// ==========================================
// OFFDAY - Website Pemrograman Web
// ==========================================

// Page View Counter
$counterFile = __DIR__ . '/counter.txt';
$visitors = 0;

if (!file_exists($counterFile)) {
    file_put_contents($counterFile, '0');
}

$fp = fopen($counterFile, 'c+');

if ($fp !== false) {
    if (flock($fp, LOCK_EX)) {
        $content = stream_get_contents($fp);
        $visitors = max(0, (int) trim($content));
        $visitors++;

        rewind($fp);
        ftruncate($fp, 0);
        fwrite($fp, (string) $visitors);
        fflush($fp);

        flock($fp, LOCK_UN);
    }
    fclose($fp);
}

// Fungsi untuk mengamankan output HTML
function cleanOutput($value) {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

$friends = require __DIR__ . '/friends-data.php';

// Pemrosesan formulir dengan metode POST
$success = false;
$error = '';
$name = '';
$email = '';
$interest = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $interest = trim($_POST['interest'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $allowedInterests = [
        'Sports',
        'Music',
        'Gaming',
        'Fashion & Lifestyle',
        'Outdoor & Travel'
    ];

    if (
        $name === '' ||
        $email === '' ||
        $interest === '' ||
        $message === ''
    ) {
        $error = 'Semua kolom wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Masukkan alamat email yang valid.';
    } elseif (!in_array($interest, $allowedInterests, true)) {
        $error = 'Pilih kategori minat yang tersedia.';
    } else {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>OFFDAY — Your People, Your Kind of Day</title>

    <meta name="description"
          content="OFFDAY membantu kamu menemukan teman
          dengan minat yang sama, mulai dari olahraga,
          musik, gaming, hingga petualangan.">

    <link rel="stylesheet" href="Uts%20Nathan.Css">
</head>

<body>

<!-- NAVIGATION -->
<header class="navbar">
    <a href="#home" class="logo">
        OFF<span>DAY</span>
        <span class="logo-dot"></span>
    </a>

    <nav class="nav-links">
        <a href="Uts%20Nathan.php#home">Home</a>
        <a href="#about">About</a>
        <a href="communities.php">Communities</a>
        <a href="premium.php">Premium</a>
        <a href="find-friends.php">Find Friends</a>
        <a href="chat.php">Chat</a>
        <a href="#how-it-works">How It Works</a>
        <a href="#contact">Contact Us</a>
    </nav>

    <a href="find-friends.php" class="nav-button">Find Your People ↗</a>
</header>

<main>

<!-- HERO / HOME -->
<section class="hero" id="home">
    <div class="hero-content">
        <p class="eyebrow hero-eyebrow">
            <span class="hero-eyebrow-dot"></span>
            JAZZ NOTES. REAL CONNECTIONS.
        </p>

        <h1>
            Find your<br>
            people. Feel the <span>groove.</span>
        </h1>

        <p class="hero-description">
            Dari alunan jazz yang menenangkan sampai rencana akhir pekan,
            temukan teman yang satu frekuensi dan nikmati momen dengan
            suasana yang lebih santai.
        </p>

        <div class="hero-actions">
            <a href="communities.php" class="button-primary">
                Explore Communities ↗
            </a>

            <a href="find-friends.php" class="button-secondary">
                Find Your People ↗
            </a>
        </div>

        <div class="hero-vibe">
            <span class="vibe-equalizer" aria-hidden="true">
                <i></i><i></i><i></i><i></i><i></i>
            </span>
            <span>ON REPEAT</span>
            <span class="vibe-divider"></span>
            <strong>JAZZ · SOUL · GOOD COMPANY</strong>
        </div>

        <div class="community-proof">
            <div class="proof-avatars" aria-hidden="true">
                <img src="images/friends-cafe.jpeg" alt="">
                <img src="images/futsal-team.jpeg" alt="">
                <img src="images/outdoor-friends.jpeg" alt="">
            </div>
            <p><strong>Mulai dari satu minat.</strong><br>Bangun cerita bersama.</p>
        </div>
    </div>

    <div class="hero-visual">
        <div class="hero-image image-placeholder">
            <img src="images/city-friends.jpeg"
                 alt="Teman-teman berkumpul dan beraktivitas">

            <div class="jazz-stamp" aria-hidden="true">
                <span class="jazz-stamp-note">♫</span>
                <span>OFFDAY AFTER HOURS</span>
                <strong>JAZZ SESSIONS</strong>
            </div>

            <div class="image-label">
                <span>OFFDAY RADIO · JAZZ MOOD</span>
                <strong>Good music, good company.</strong>
            </div>
        </div>

        <div class="rnb-record" aria-hidden="true">
            <span class="record-label">
                <strong>OFF</strong>
                <strong>DAY</strong>
                <small>SIDE A · 01</small>
            </span>
        </div>

        <div class="floating-card">
            <span class="floating-icon" aria-hidden="true">♫</span>
            <div>
                <strong>Good music, new friends</strong>
                <p>Obrolan santai, koneksi yang berarti.</p>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT -->
<section class="section about-section" id="about">
    <div class="section-heading">
        <p class="eyebrow">01 — ABOUT OFFDAY</p>
        <h2>Good days are better <span>together.</span></h2>
    </div>

    <div class="about-grid">
        <div class="about-copy">
            <p>
                OFFDAY adalah platform social discovery
                yang membantu orang menemukan teman,
                komunitas, dan partner aktivitas berdasarkan
                minat yang mereka sukai.
            </p>

            <p>
                Kami percaya bahwa membangun koneksi
                tidak harus dimulai dari percakapan yang
                canggung. Cukup mulai dari sesuatu yang
                kamu sukai.
            </p>

            <a href="#how-it-works" class="text-link">
                Get to know us better ↗
            </a>
        </div>

        <div class="about-stat">
            <span class="stat-symbol">✳</span>
            <h3>One interest.</h3>
            <h3>Many connections.</h3>
            <p>
                Satu minat bisa menjadi awal dari
                pertemanan, pengalaman, dan cerita baru.
            </p>
        </div>
    </div>
</section>

<!-- COMMUNITIES -->
<section class="section communities-section"
         id="communities">

    <div class="section-heading heading-row">
        <div>
            <p class="eyebrow">02 — FIND YOUR INTEREST</p>
            <h2>Your thing. <span>Your people.</span></h2>
        </div>

        <p class="heading-description">
            Apa pun minatmu, selalu ada orang
            yang ingin melakukannya bersama.
        </p>
    </div>

    <div class="community-grid">

        <article class="community-card">
            <div class="community-image">
                <img src="images/futsal-team.jpeg"
                     alt="Teman-teman bermain futsal bersama">
                <span class="category-number">01</span>
            </div>
            <div class="community-info">
                <div>
                    <h3>Sports</h3>
                    <p>Move together, grow together.</p>
                </div>
                <a href="find-friends.php" aria-label="Cari teman olahraga">↗</a>
            </div>
        </article>

        <article class="community-card">
            <div class="community-image">
                <img src="images/friends-cafe.jpeg"
                     alt="Teman-teman berkumpul di kafe">
                <span class="category-number">02</span>
            </div>
            <div class="community-info">
                <div>
                    <h3>Music</h3>
                    <p>Same vibe, same playlist.</p>
                </div>
                <a href="find-friends.php" aria-label="Cari teman musik">↗</a>
            </div>
        </article>

        <article class="community-card">
            <div class="community-image">
                <img src="images/friends-hangout.jpeg"
                     alt="Tiga teman menghabiskan waktu bersama">
                <span class="category-number">03</span>
            </div>
            <div class="community-info">
                <div>
                    <h3>Gaming</h3>
                    <p>Find your next teammate.</p>
                </div>
                <a href="find-friends.php" aria-label="Cari teman gaming">↗</a>
            </div>
        </article>

        <article class="community-card">
            <div class="community-image">
                <img src="images/friends-night-out.jpeg"
                     alt="Teman-teman berkumpul di malam hari">
                <span class="category-number">04</span>
            </div>
            <div class="community-info">
                <div>
                    <h3>Fashion & Lifestyle</h3>
                    <p>Share your style, share your story.</p>
                </div>
                <a href="find-friends.php"
                   aria-label="Cari teman fashion dan lifestyle">↗</a>
            </div>
        </article>

        <article class="community-card">
            <div class="community-image">
                <img src="images/outdoor-friends.jpeg"
                     alt="Teman-teman menikmati perjalanan ke pantai">
                <span class="category-number">05</span>
            </div>
            <div class="community-info">
                <div>
                    <h3>Outdoor & Travel</h3>
                    <p>Go further, together.</p>
                </div>
                <a href="find-friends.php" aria-label="Cari teman jalan-jalan">↗</a>
            </div>
        </article>

        <article class="community-card">
            <div class="community-image">
                <img src="images/community-dinner.jpeg"
                     alt="Satu komunitas makan bersama">
                <span class="category-number">06</span>
            </div>
            <div class="community-info">
                <div>
                    <h3>Meet Your Circle</h3>
                    <p>Good conversations, new connections.</p>
                </div>
                <a href="find-friends.php" aria-label="Temukan circle kamu">↗</a>
            </div>
        </article>

        <article class="community-card">
            <div class="community-image">
                <img src="images/friends-evening.jpeg"
                     alt="Dua teman menikmati waktu bersama">
                <span class="category-number">07</span>
            </div>
            <div class="community-info">
                <div>
                    <h3>One Good Moment</h3>
                    <p>Little plans, lasting memories.</p>
                </div>
                <a href="find-friends.php" aria-label="Mulai momen baru">↗</a>
            </div>
        </article>

        <article class="community-card">
            <div class="community-image">
                <img src="images/city-friends.jpeg"
                     alt="Teman-teman berjalan dan menjelajahi kota">
                <span class="category-number">08</span>
            </div>
            <div class="community-info">
                <div>
                    <h3>City Hangout</h3>
                    <p>Explore the city together.</p>
                </div>
                <a href="find-friends.php" aria-label="Jelajahi kota bersama">↗</a>
            </div>
        </article>

    </div>
</section>

<!-- FIND FRIENDS -->
<section class="section friends-section" id="friends">
    <div class="section-heading heading-row">
        <div>
            <p class="eyebrow">03 — TEMUKAN TEMAN</p>
            <h2>Pilih teman.<br><span>Mulai dari OFFDAY.</span></h2>
        </div>

        <p class="heading-description">
            Lihat foto anggota dan pilih teman yang ingin kamu kenal.
        </p>
    </div>

    <div class="friend-notice">
        <span aria-hidden="true">i</span>
        <p>
            Tambahkan teman ke daftar pribadimu, lalu lihat semua
            teman yang sudah kamu tambahkan. Daftar disimpan di browser ini.
        </p>
    </div>

    <div class="friend-tools">
        <div class="friend-tabs" role="group"
             aria-label="Tampilkan daftar teman">
            <button class="friend-tab is-active" type="button"
                    data-view="all" aria-pressed="true">Semua profil</button>
            <button class="friend-tab" type="button"
                    data-view="friends" aria-pressed="false">
                Teman saya <span id="my-friend-count">0</span>
            </button>
        </div>
        <div class="friend-search">
            <label for="friend-search">Cari nama teman</label>
            <input id="friend-search" type="search"
                   placeholder="Ketik nama..."
                   autocomplete="off">
        </div>
    </div>

    <p class="friend-results" id="friend-results"
       aria-live="polite">11 profil</p>
    <p class="friend-feedback" id="friend-feedback"
       role="status" aria-live="polite"></p>

    <div class="friend-grid">
        <?php foreach ($friends as $friendId => $friend): ?>
            <article class="friend-card"
                     data-friend-id="<?= cleanOutput($friendId) ?>"
                     data-name="<?= cleanOutput($friend['name']) ?>">
                <div class="friend-photo">
                    <img src="images/<?= cleanOutput($friend['image']) ?>"
                         alt="Foto profil <?= cleanOutput($friend['name']) ?>"
                         loading="lazy">
                    <span class="community-badge">Komunitas OFFDAY</span>
                    <button class="profile-open" type="button"
                            data-profile-open="<?= cleanOutput($friendId) ?>">
                        Lihat profil
                    </button>
                </div>
                <div class="friend-card-content">
                    <div class="friend-card-heading">
                        <h3><?= cleanOutput($friend['name']) ?></h3>
                    </div>
                    <p>Temukan teman baru di komunitas OFFDAY.</p>
                    <button class="friend-select" type="button"
                            data-friend-action="<?= cleanOutput($friendId) ?>"
                            aria-pressed="false">
                        <span data-friend-label>Tambah teman</span>
                        <span aria-hidden="true">＋</span>
                    </button>
                    <a class="friend-chat-link"
                       href="chat.php?friend=<?= rawurlencode($friendId) ?>"
                       hidden>Chat sekarang <span aria-hidden="true">↗</span></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <dialog class="friend-dialog" id="friend-dialog"
            aria-labelledby="friend-dialog-name">
        <button class="dialog-close" type="button"
                aria-label="Tutup profil">×</button>
        <img class="dialog-photo" id="friend-dialog-photo" src=""
             alt="">
        <div class="dialog-content">
            <span class="community-badge dialog-badge">Komunitas OFFDAY</span>
            <h3 id="friend-dialog-name"></h3>
            <p>Anggota komunitas OFFDAY. Tambahkan sebagai teman
                untuk menyimpan profil ini di daftar temanmu.</p>
            <button class="friend-select dialog-friend-action"
                    id="friend-dialog-action" type="button"
                    aria-pressed="false">
                <span data-friend-label>Tambah teman</span>
                <span aria-hidden="true">＋</span>
            </button>
        </div>
    </dialog>
</section>

<!-- HOW IT WORKS -->
<section class="section process-section"
         id="how-it-works">

    <div class="section-heading">
        <p class="eyebrow">04 — HOW IT WORKS</p>
        <h2>Less scrolling. <span>More living.</span></h2>
        <p class="heading-description">
            Mulai menemukan circle kamu dalam tiga langkah.
        </p>
    </div>

    <div class="steps-grid">
        <article class="step-card">
            <span class="step-number">01</span>
            <h3>Pick your interest</h3>
            <p>
                Tentukan aktivitas yang kamu sukai,
                mulai dari olahraga hingga musik.
            </p>
        </article>

        <article class="step-card">
            <span class="step-number">02</span>
            <h3>Find your people</h3>
            <p>
                Temukan orang yang punya ketertarikan
                dan semangat yang sama.
            </p>
        </article>

        <article class="step-card">
            <span class="step-number">03</span>
            <h3>Make it happen</h3>
            <p>
                Mulai berkenalan, rencanakan aktivitas,
                dan ciptakan pengalaman baru.
            </p>
        </article>
    </div>
</section>

<!-- CONTACT / PHP FORM -->
<section class="section contact-section" id="contact">

    <div class="contact-copy">
        <p class="eyebrow">05 — LET'S CONNECT</p>

        <h2>Your next circle<br>starts <span>here.</span></h2>

        <p>
            Ceritakan minatmu dan mulai langkah
            pertamamu untuk menemukan komunitas OFFDAY.
        </p>

        <div class="contact-detail">
            <span class="status-dot"></span>
            Your next connection could start today.
        </div>
    </div>

    <div class="contact-form-wrap">
        <h3>Find your people.</h3>
        <p class="form-intro">
            Isi formulir di bawah untuk menunjukkan minatmu.
        </p>

        <?php if ($success): ?>
            <div class="notice success-notice">
                <strong>Terima kasih, <?= cleanOutput($name) ?>!</strong>
                <p>
                    Formulir berhasil diproses.
                    Minat yang kamu pilih:
                    <?= cleanOutput($interest) ?>.
                </p>
                <p>
                    Catatan: formulir ini belum menyimpan
                    data ke database atau mengirim email.
                </p>
            </div>
        <?php elseif ($error !== ''): ?>
            <div class="notice error-notice">
                <?= cleanOutput($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="#contact">
            <div class="form-group">
                <label for="name">Your name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Masukkan nama kamu"
                    value="<?= cleanOutput($name) ?>"
                    maxlength="100"
                    required>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="nama@email.com"
                    value="<?= cleanOutput($email) ?>"
                    maxlength="254"
                    required>
            </div>

            <div class="form-group">
                <label for="interest">Choose your interest</label>
                <select id="interest" name="interest" required>
                    <option value="">Pilih kategori minat</option>
                    <option value="Sports"
                        <?= $interest === 'Sports' ? 'selected' : '' ?>>
                        Sports
                    </option>
                    <option value="Music"
                        <?= $interest === 'Music' ? 'selected' : '' ?>>
                        Music
                    </option>
                    <option value="Gaming"
                        <?= $interest === 'Gaming' ? 'selected' : '' ?>>
                        Gaming
                    </option>
                    <option value="Fashion & Lifestyle"
                        <?= $interest === 'Fashion & Lifestyle'
                            ? 'selected' : '' ?>>
                        Fashion & Lifestyle
                    </option>
                    <option value="Outdoor & Travel"
                        <?= $interest === 'Outdoor & Travel'
                            ? 'selected' : '' ?>>
                        Outdoor & Travel
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="message">Tell us about your plan</label>
                <textarea
                    id="message"
                    name="message"
                    rows="4"
                    maxlength="1000"
                    placeholder="Misalnya, ingin mencari teman badminton..."
                    required><?= cleanOutput($message) ?></textarea>
            </div>

            <button type="submit" class="button-primary submit-button">
                Submit Your Interest ↗
            </button>

            <p class="form-footnote">
                Dengan mengirim formulir, kamu menunjukkan
                ketertarikanmu untuk terhubung melalui OFFDAY.
            </p>
        </form>
    </div>
</section>

</main>

<!-- FOOTER -->
<footer class="footer">
    <a href="#home" class="logo footer-logo">
        OFF<span>DAY</span><span class="logo-dot"></span>
    </a>

    <p>Your people. Your kind of day.</p>

    <div class="page-counter">
        <span class="status-dot"></span>
        Page views: <strong><?= (int) $visitors ?></strong>
    </div>

    <p class="copyright">
        &copy; <?= date('Y') ?> OFFDAY. Made for better days.
    </p>
</footer>

<script src="friends.js" defer></script>

</body>
</html>
