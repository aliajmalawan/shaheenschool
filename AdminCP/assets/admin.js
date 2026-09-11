// AdminCP - Shared sidebar toggle behaviour (mobile drawer)
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const openBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('sidebarClose');

        if (!sidebar || !backdrop) return;

        function openSidebar() {
            sidebar.classList.add('is-open');
            backdrop.classList.add('is-open');
            if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
        }

        function closeSidebar() {
            sidebar.classList.remove('is-open');
            backdrop.classList.remove('is-open');
            if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
        }

        if (openBtn) openBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        backdrop.addEventListener('click', closeSidebar);
    });
})();
