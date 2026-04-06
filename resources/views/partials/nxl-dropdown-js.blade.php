<script>
(function () {
    function openMenu(menu, toggle) {
        const rect    = toggle.getBoundingClientRect();
        const menuW   = 180;
        const menuH   = menu.scrollHeight || 140;
        const below   = window.innerHeight - rect.bottom;
        const right   = window.innerWidth  - rect.right;

        menu.style.cssText = [
            'position:fixed',
            'z-index:9999',
            'min-width:' + menuW + 'px',
            'margin:0',
            'display:block',
            'top:'  + (below < menuH + 8 ? rect.top  - menuH - 4 : rect.bottom + 4) + 'px',
            'left:' + (right < menuW      ? rect.right - menuW    : rect.left)       + 'px',
        ].join(';');

        menu.classList.add('show', 'nxl-show');
    }

    function closeMenu(menu) {
        menu.classList.remove('show', 'nxl-show');
        menu.style.cssText = '';
    }

    function closeAll(except) {
        document.querySelectorAll('.nxl-dropdown-menu.nxl-show').forEach(function (m) {
            if (m !== except) closeMenu(m);
        });
    }

    document.addEventListener('click', function (e) {
        const toggle = e.target.closest('.nxl-dropdown-toggle');

        if (toggle) {
            e.stopPropagation();
            const wrapper = toggle.closest('[data-nxl-dropdown]');
            const menu    = wrapper ? wrapper.querySelector('.nxl-dropdown-menu') : null;
            if (!menu) return;

            if (menu.classList.contains('nxl-show')) {
                closeMenu(menu);
            } else {
                closeAll(menu);
                openMenu(menu, toggle);
            }
            return;
        }

        closeAll();
    });

    window.addEventListener('scroll', function () { closeAll(); }, true);
    window.addEventListener('resize', function () { closeAll(); });
})();
</script>