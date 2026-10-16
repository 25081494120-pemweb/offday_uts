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
       aria-live="polite">11 profil ditampilkan</p>
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
        <img class="dialog-photo" id="friend-dialog-photo" src="" alt="">
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
