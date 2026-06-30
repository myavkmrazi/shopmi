import $ from 'jquery';
window.$ = window.jQuery = $;

import('owl.carousel').then(() => {
    console.log('🦉 Owl Carousel loaded via Vite');
    initializeOwlCarousels();
}).catch(error => {
    console.error('❌ Owl Carousel loading failed:', error);
});

import 'owl.carousel/dist/assets/owl.carousel.css';

let carouselsInitialized = false;

function initializeOwlCarousels() {
    if (carouselsInitialized) {
        console.log('⏩ Carousels already initialized');
        return;
    }

    console.log('🚀 Initializing Owl Carousels...');

    const carousels = $('.owl-carousel');
    console.log('Found carousels:', carousels.length);

    if (carousels.length === 0) {
        console.log('❌ No carousels found');
        return;
    }

    if (typeof $.fn.owlCarousel === 'undefined') {
        console.log('❌ Owl Carousel not available');
        setTimeout(initializeOwlCarousels, 100);
        return;
    }

    try {
        carousels.each(function () {
            const $carousel = $(this);

            if ($carousel.hasClass('owl-loaded')) {
                console.log('⏩ Carousel already initialized, skipping');
                return;
            }

            $carousel.owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                smartSpeed: 700,
                slideSpeed: 600,
                paginationSpeed: 600,
                fluidSpeed: 700,
                navSpeed: 700,
                dotsSpeed: 700,
                dragEndSpeed: 700,
                navText: [
                    '<span class="home-carousel-arrow" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>',
                    '<span class="home-carousel-arrow" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>',
                ],
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    768: { items: 3 },
                    1000: { items: 4 }
                }
            });
        });

        carouselsInitialized = true;
        console.log('✅ All carousels initialized successfully');

    } catch (error) {
        console.error('❌ Error initializing carousels:', error);
    }
}

function initShopmiMenus() {
    document.addEventListener('click', (event) => {
        const nestedToggle = event.target.closest('.shopmi-navbar .dropend > .dropdown-toggle');

        if (nestedToggle) {
            event.preventDefault();
            event.stopPropagation();

            const parent = nestedToggle.closest('.dropend');
            const menu = parent?.querySelector(':scope > .dropdown-menu');

            if (!menu) {
                return;
            }

            parent.parentElement?.querySelectorAll(':scope > .dropend > .dropdown-menu.show').forEach((openMenu) => {
                if (openMenu !== menu) {
                    openMenu.classList.remove('show');
                }
            });

            menu.classList.toggle('show');
            return;
        }

        const navLink = event.target.closest('.shopmi-navbar .dropdown-menu a[href]:not([href="#"])');

        if (navLink) {
            document.querySelectorAll('.shopmi-navbar .dropdown-menu.show').forEach((menu) => {
                menu.classList.remove('show');
            });
        }
    });
}


function enableSmoothScroll() {
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href^="#"]');
        if (!link) return;

        const href = link.getAttribute('href');
        if (!href || href === '#') return;

        if (!href.startsWith('#')) return;

        const targetId = href.substring(1); // Убираем #
        if (!targetId) return;

        const targetElement = document.getElementById(targetId);
        if (!targetElement) return;

        e.preventDefault();

        smoothScrollTo(targetElement, {
            duration: 1000,
            offset: 80,
            easing: (t) => t < 0.5
                ? 2 * t * t
                : 1 - Math.pow(-2 * t + 2, 2) / 2
        });
    }, { passive: false });

    console.log('✅ Smooth scroll enabled');
}


function smoothScrollTo(element, options = {}) {
    const {
        duration = 800,
        offset = 0,
        easing = (t) => t
    } = options;

    const targetPosition = element.getBoundingClientRect().top + window.pageYOffset - offset;
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    let startTime = null;

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const progress = Math.min(timeElapsed / duration, 1);

        const easeProgress = easing(progress);

        window.scrollTo(0, startPosition + distance * easeProgress);

        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        }
    }

    requestAnimationFrame(animation);
}



function initScrollProgress() {
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: #0f0f10;
        z-index: 9999;
        transition: width 0.1s ease;
        width: 0%;
    `;
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const winScroll = document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + '%';
    }, { passive: true });
}

function initLazyLoading() {
    const observerOptions = {
        root: null,
        rootMargin: '50px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.shopmi-reveal').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(16px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });
}

function initParallax() {
    const banner = document.querySelector('.carousel-item img');
    if (banner) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            banner.style.transform = `translateY(${scrolled * 0.3}px)`;
        }, { passive: true });
    }
}

function addSmoothStyles() {
    const style = document.createElement('style');
    style.textContent = `
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
        }

        .fade-in-section {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in-section.visible {
            opacity: 1;
            transform: translateY(0);
        }
    `;
    document.head.appendChild(style);
}

document.addEventListener('DOMContentLoaded', function () {
    console.log('📄 DOM Content Loaded');

    enableSmoothScroll();
    initShopmiMenus();
    initScrollProgress();
    initLazyLoading();
    initParallax();
    addSmoothStyles();

    setTimeout(initializeOwlCarousels, 300);
}, { passive: true });

document.addEventListener('show.bs.offcanvas', function () {
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    document.querySelector('.shopmi-navbar').style.marginRight = scrollbarWidth + 'px';
});

document.addEventListener('hidden.bs.offcanvas', function () {
    document.querySelector('.shopmi-navbar').style.marginRight = '';
});
if (typeof Livewire !== 'undefined') {
    console.log('🔌 Livewire detected');

    let livewireTimeout;
    Livewire.hook('morph.updated', () => {
        console.log('🔄 Livewire component updated');

        clearTimeout(livewireTimeout);
        livewireTimeout = setTimeout(() => {
            carouselsInitialized = false;
            initializeOwlCarousels();

            initLazyLoading();
        }, 400);
    });
}
