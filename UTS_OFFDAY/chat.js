(() => {
    const friendsKey = 'offday-friends-v1';
    const messagesKey = 'offday-chat-messages-v1';
    const friendLinks = [...document.querySelectorAll('[data-chat-friend]')];
    const friendIds = new Set(
        friendLinks.map((link) => link.dataset.chatFriend)
    );
    const friendCount = document.querySelector('#chat-friend-count');
    const emptyFriends = document.querySelector('#chat-friends-empty');
    let myFriends = new Set();

    try {
        const savedFriends = localStorage.getItem(friendsKey);
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
        emptyFriends.hidden = false;
        emptyFriends.textContent =
            'Daftar teman tidak dapat dibaca dari penyimpanan browser.';
        return;
    }

    friendCount.textContent = String(myFriends.size);
    emptyFriends.hidden = myFriends.size !== 0;

    friendLinks.forEach((link) => {
        const isFriend = myFriends.has(link.dataset.chatFriend);
        link.hidden = !isFriend;
        if (isFriend) {
            link.setAttribute(
                'aria-current',
                link.getAttribute('aria-current') === 'page' ? 'page' : 'false'
            );
        }
    });

    const room = document.querySelector('.chat-room-header');
    const form = document.querySelector('#chat-form');
    if (!room || !form) return;

    const activeFriendId = room.dataset.activeFriend;
    if (!myFriends.has(activeFriendId)) {
        document.querySelector('#chat-messages').innerHTML = `
            <div class="chat-placeholder">
                <span aria-hidden="true">i</span>
                <p>Tambahkan ${room.dataset.activeName} sebagai teman
                    terlebih dahulu untuk membuka chat.</p>
                <a href="find-friends.php">Kembali ke Find Friends ↗</a>
            </div>`;
        form.hidden = true;
        return;
    }

    const messagesElement = document.querySelector('#chat-messages');
    const input = document.querySelector('#chat-input');
    const status = document.querySelector('#chat-status');
    let messages = {};

    const showStorageError = () => {
        status.textContent =
            'Pesan tidak dapat disimpan. Periksa pengaturan penyimpanan browser.';
        status.classList.add('is-error');
    };

    try {
        const savedMessages = localStorage.getItem(messagesKey);
        if (savedMessages !== null) {
            const parsedMessages = JSON.parse(savedMessages);
            if (
                parsedMessages === null ||
                typeof parsedMessages !== 'object' ||
                Array.isArray(parsedMessages)
            ) {
                throw new Error('Data chat tersimpan tidak valid.');
            }
            messages = parsedMessages;
        }
    } catch (error) {
        showStorageError();
        form.querySelector('button').disabled = true;
    }

    const renderMessages = () => {
        messagesElement.replaceChildren();
        const conversation = Array.isArray(messages[activeFriendId])
            ? messages[activeFriendId]
            : [];

        if (conversation.length === 0) {
            const placeholder = document.createElement('div');
            placeholder.className = 'chat-placeholder';
            placeholder.innerHTML =
                '<span aria-hidden="true">✳</span>' +
                '<p>Mulai percakapan dengan temanmu.</p>';
            messagesElement.append(placeholder);
            return;
        }

        conversation.forEach((message) => {
            const bubble = document.createElement('article');
            bubble.className = 'chat-bubble chat-bubble-mine';
            const text = document.createElement('p');
            text.textContent = message.text;
            const time = document.createElement('time');
            time.dateTime = message.sentAt;
            time.textContent = new Date(message.sentAt).toLocaleTimeString(
                'id-ID',
                { hour: '2-digit', minute: '2-digit' }
            );
            bubble.append(text, time);
            messagesElement.append(bubble);
        });

        messagesElement.scrollTop = messagesElement.scrollHeight;
    };

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        const conversation = Array.isArray(messages[activeFriendId])
            ? messages[activeFriendId]
            : [];
        const updatedMessages = {
            ...messages,
            [activeFriendId]: [
                ...conversation,
                { text, sentAt: new Date().toISOString() }
            ]
        };

        try {
            localStorage.setItem(messagesKey, JSON.stringify(updatedMessages));
        } catch (error) {
            showStorageError();
            return;
        }

        messages = updatedMessages;
        input.value = '';
        status.textContent = 'Pesan tersimpan di browser ini (mode demo).';
        status.classList.remove('is-error');
        renderMessages();
        input.focus();
    });

    renderMessages();
})();
