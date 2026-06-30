/**
 * SHOPMI — Бургер-меню для мобильной навигации
 */

document.addEventListener('DOMContentLoaded', () => {

    const burger = document.querySelector('.shopmi-burger');
    const links = document.querySelector('.shopmi-navbar__links');
    const end = document.querySelector('.shopmi-navbar__end');

    if (!burger) return;

    function isMobile() {
        return window.innerWidth <= 992;
    }

    function closeMenu() {
        burger.classList.remove('is-open');
        links?.classList.remove('is-open');
        end?.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    function initMobileDropdowns() {
        document.querySelectorAll('.shopmi-navbar__links .dropdown-toggle').forEach(toggle => {
            toggle.removeAttribute('data-bs-toggle');

            if (toggle._shopmiInit) return;
            toggle._shopmiInit = true;

            toggle.addEventListener('click', (e) => {
                if (!isMobile()) return;
                e.preventDefault();
                e.stopPropagation();

                const parent = toggle.closest('.dropdown, .dropend');
                if (!parent) return;

                const menu = parent.querySelector(':scope > .dropdown-menu');
                if (!menu) return;

                const isOpen = menu.classList.contains('show');

                parent.parentElement?.querySelectorAll(':scope > .dropdown, :scope > .dropend').forEach(sib => {
                    if (sib !== parent) {
                        sib.querySelector('.dropdown-menu')?.classList.remove('show');
                    }
                });

                menu.classList.toggle('show', !isOpen);
            });
        });
    }

    initMobileDropdowns();

    burger.addEventListener('click', () => {
        const isOpen = burger.classList.toggle('is-open');
        links?.classList.toggle('is-open', isOpen);
        end?.classList.toggle('is-open', isOpen);
        burger.setAttribute('aria-expanded', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';

        if (isOpen) initMobileDropdowns();
    });

    document.addEventListener('click', (e) => {
        if (!burger.closest('nav').contains(e.target)) closeMenu();
    });

    window.addEventListener('resize', () => {
        if (!isMobile()) closeMenu();
    });
});
