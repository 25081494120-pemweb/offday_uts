(() => {
    const storageKey = 'offday-friends-v1';
    const friendCards = [...document.querySelectorAll('.friend-card')];
    const friendIds = new Set(
        friendCards.map((card) => card.dataset.friendId)
    );
    const friendSearch = document.querySelector('#friend-search');
    const friendResults = document.querySelector('#friend-results');
    const friendFeedback = document.querySelector('#friend-feedback');
    const friendCount = document.querySelector('#my-friend-count');
    const friendGrid = document.querySelector('.friend-grid');
    const friendDialog = document.querySelector('#friend-dialog');
    const dialogPhoto = document.querySelector('#friend-dialog-photo');
    const dialogName = document.querySelector('#friend-dialog-name');
    const dialogAction = document.querySelector('#friend-dialog-action');
    if (
        friendCards.length === 0 ||
        !friendSearch ||
        !friendResults ||
        !friendFeedback ||
        !friendCount ||
        !friendGrid ||
        !friendDialog ||
        !dialogPhoto ||
        !dialogName ||
        !dialogAction
    ) {
        return;
    }

    let currentView = 'all';
    let myFriends = new Set();

    const showFeedback = (message, isError = false) => {
        friendFeedback.textContent = message;
        friendFeedback.classList.toggle('is-error', isError);
    };

    try {
        const savedFriends = localStorage.getItem(storageKey);
        if (savedFriends !== null) {
            const parsedFriends = JSON.parse(savedFriends);
            if (!Array.isArray(parsedFriends)) {
                throw new Error('Daftar teman tersimpan tidak valid.');
            }
            myFriends = new Set(
                parsedFriends.filter((friendId) => friendIds.has(friendId))
            );
        }
    } catch (error) {
        myFriends = new Set();
        showFeedback(
            'Daftar teman browser tidak dapat dibaca. ' +
            'Silakan izinkan penyimpanan situs di browser.',
            true
        );
    }

    const renderFriends = () => {
        const searchTerm = friendSearch.value
            .trim()
            .toLocaleLowerCase('id');
        let visibleCount = 0;

        friendCount.textContent = String(myFriends.size);

        friendCards.forEach((card) => {
            const friendId = card.dataset.friendId;
            const isFriend = myFriends.has(friendId);
            const matchesSearch = card.dataset.name
                .toLocaleLowerCase('id')
                .includes(searchTerm);
            const matchesView = currentView === 'all' || isFriend;
            card.hidden = !matchesSearch || !matchesView;
            if (!card.hidden) visibleCount++;
        });

        document.querySelectorAll('[data-friend-action]').forEach((button) => {
            const isFriend = myFriends.has(button.dataset.friendAction);
            const label = button.querySelector('[data-friend-label]');
            const icon = button.querySelector('[aria-hidden="true"]');
            const profile = friendCards.find(
                (card) => card.dataset.friendId === button.dataset.friendAction
            );
            const card = button.closest('.friend-card');
            label.textContent = isFriend ? 'Hapus teman' : 'Tambah teman';
            icon.textContent = isFriend ? '✓' : '＋';
            button.setAttribute(
                'aria-label',
                isFriend
                    ? `Hapus ${profile.dataset.name} dari teman`
                    : `Tambah ${profile.dataset.name} sebagai teman`
            );
            button.setAttribute('aria-pressed', String(isFriend));
            button.classList.toggle('is-added', isFriend);
            if (card) {
                const chatLink = card.querySelector('.friend-chat-link');
                chatLink.hidden = !isFriend;
            }
        });

        friendResults.textContent = currentView === 'friends'
            ? visibleCount === 0 && myFriends.size === 0
                ? 'Belum ada teman. Tambahkan teman dari Semua profil.'
                : `${visibleCount} teman ditampilkan`
            : visibleCount === 0
                ? 'Nama tidak ditemukan.'
                : `${visibleCount} profil ditampilkan`;
    };

    const setFriendStatus = (friendId) => {
        const wasFriend = myFriends.has(friendId);
        const updatedFriends = new Set(myFriends);
        if (wasFriend) {
            updatedFriends.delete(friendId);
        } else {
            updatedFriends.add(friendId);
        }

        try {
            localStorage.setItem(
                storageKey,
                JSON.stringify([...updatedFriends])
            );
        } catch (error) {
            showFeedback(
                'Perubahan tidak tersimpan. Periksa pengaturan penyimpanan browser.',
                true
            );
            return;
        }

        myFriends = updatedFriends;
        showFeedback(wasFriend
            ? 'Teman dihapus dari daftar.'
            : 'Teman ditambahkan ke daftar.');
        renderFriends();
    };

    document.querySelectorAll('.friend-tab').forEach((tab) => {
        tab.addEventListener('click', () => {
            currentView = tab.dataset.view;
            document.querySelectorAll('.friend-tab').forEach((item) => {
                const isActive = item === tab;
                item.classList.toggle('is-active', isActive);
                item.setAttribute('aria-pressed', String(isActive));
            });
            renderFriends();
        });
    });

    friendSearch.addEventListener('input', renderFriends);
    friendGrid.addEventListener('click', (event) => {
        const action = event.target.closest('[data-friend-action]');
        if (action) setFriendStatus(action.dataset.friendAction);
    });
    dialogAction.addEventListener('click', () => {
        setFriendStatus(dialogAction.dataset.friendAction);
    });

    document.querySelectorAll('[data-profile-open]').forEach((button) => {
        button.addEventListener('click', () => {
            const card = friendCards.find(
                (item) => item.dataset.friendId === button.dataset.profileOpen
            );
            if (!card) return;

            dialogPhoto.src = card.querySelector('.friend-photo img').src;
            dialogPhoto.alt = `Foto profil ${card.dataset.name}`;
            dialogName.textContent = card.dataset.name;
            dialogAction.dataset.friendAction = card.dataset.friendId;
            renderFriends();
            friendDialog.showModal();
        });
    });

    friendDialog.querySelector('.dialog-close').addEventListener(
        'click',
        () => friendDialog.close()
    );
    friendDialog.addEventListener('click', (event) => {
        if (event.target === friendDialog) friendDialog.close();
    });

    renderFriends();
})();
