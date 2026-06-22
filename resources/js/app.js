// resources/js/app.js
import $ from 'jquery';
window.$ = window.jQuery = $;

// Динамический импорт Owl Carousel
import('owl.carousel').then(() => {
    console.log('🦉 Owl Carousel loaded via Vite');
    initializeOwlCarousels();
}).catch(error => {
    console.error('❌ Owl Carousel loading failed:', error);
});

// Импортируем CSS
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

            // Если уже инициализирован - пропускаем
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
                smartSpeed: 700,              // Увеличил для плавности
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

/**
 * ПЛАВНАЯ ПРОКРУТКА С УЛУЧШЕННОЙ АНИМАЦИЕЙ
 */
function enableSmoothScroll() {
    // Используем делегирование событий для производительности
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href^="#"]');
        if (!link) return;

        const href = link.getAttribute('href');
        if (!href || href === '#') return;

        // Пропускаем ссылки, которые не являются якорями
        if (!href.startsWith('#')) return;

        const targetId = href.substring(1); // Убираем #
        if (!targetId) return;

        const targetElement = document.getElementById(targetId);
        if (!targetElement) return;

        e.preventDefault();

        // Кастомная плавная прокрутка с easing функцией
        smoothScrollTo(targetElement, {
            duration: 1000,           // Длительность анимации в мс
            offset: 80,                // Отступ сверху (для фиксированной шапки)
            easing: (t) => t < 0.5
                ? 2 * t * t
                : 1 - Math.pow(-2 * t + 2, 2) / 2 // easeInOutQuad
        });
    }, { passive: false });

    console.log('✅ Smooth scroll enabled');
}

/**
 * Функция для кастомной плавной прокрутки
 */
function smoothScrollTo(element, options = {}) {
    const {
        duration = 800,
        offset = 0,
        easing = (t) => t // linear по умолчанию
    } = options;

    const targetPosition = element.getBoundingClientRect().top + window.pageYOffset - offset;
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    let startTime = null;

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const progress = Math.min(timeElapsed / duration, 1);

        // Применяем easing функцию
        const easeProgress = easing(progress);

        window.scrollTo(0, startPosition + distance * easeProgress);

        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        }
    }

    requestAnimationFrame(animation);
}

/**
 * ДОПОЛНИТЕЛЬНЫЕ УЛУЧШЕНИЯ ДЛЯ ПРОКРУТКИ
 */

// 1. Индикатор прогресса прокрутки
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

// 2. Ленивая загрузка с плавным появлением
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

// 3. Параллакс эффект для баннера
function initParallax() {
    const banner = document.querySelector('.carousel-item img');
    if (banner) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            banner.style.transform = `translateY(${scrolled * 0.3}px)`;
        }, { passive: true });
    }
}

// 4. Добавляем CSS для плавной прокрутки
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

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', function () {
    console.log('📄 DOM Content Loaded');

    // Запускаем все улучшения
    enableSmoothScroll();
    initShopmiMenus();
    initScrollProgress();
    initLazyLoading();
    initParallax();
    addSmoothStyles();

    setTimeout(initializeOwlCarousels, 300);
}, { passive: true });

// Оптимизация для Livewire
if (typeof Livewire !== 'undefined') {
    console.log('🔌 Livewire detected');

    let livewireTimeout;
    Livewire.hook('morph.updated', () => {
        console.log('🔄 Livewire component updated');

        clearTimeout(livewireTimeout);
        livewireTimeout = setTimeout(() => {
            carouselsInitialized = false;
            initializeOwlCarousels();

            // Перезапускаем lazy loading для новых элементов
            initLazyLoading();
        }, 400);
    });
}
