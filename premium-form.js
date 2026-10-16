(() => {
    const form = document.querySelector('#premium-signup-form');
    const status = document.querySelector('#premium-form-status');

    if (!(form instanceof HTMLFormElement) ||
        !(status instanceof HTMLElement)) {
        return;
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        status.textContent =
            'Ini hanya demo: data tidak dikirim atau disimpan. Kamu belum terdaftar.';
    });
})();
