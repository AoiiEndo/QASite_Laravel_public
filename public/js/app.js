document.addEventListener('DOMContentLoaded', function() {
    // ハンバーガーメニューのクリックイベント
    const hamburgerMenu = document.getElementById('hamburger-menu');
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    }

    // ログアウトリンクのクリックイベント
    const logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
    }

    dayjs.extend(dayjs_plugin_relativeTime);
    dayjs.locale('ja');
});