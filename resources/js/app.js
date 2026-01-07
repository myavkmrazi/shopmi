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
                smartSpeed: 500,
                navText: ['‹', '›'],
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

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', function () {
    console.log('📄 DOM Content Loaded');
    setTimeout(initializeOwlCarousels, 300);
});

// Для Livewire с дебаунсом
if (typeof Livewire !== 'undefined') {
    console.log('🔌 Livewire detected');

    let livewireTimeout;
    Livewire.hook('morph.updated', () => {
        console.log('🔄 Livewire component updated');

        clearTimeout(livewireTimeout);
        livewireTimeout = setTimeout(() => {
            carouselsInitialized = false;
            initializeOwlCarousels();
        }, 400);
    });
    // Добавь в начало app.js
    function addPassiveEventListener(element, event, handler) {
        element.addEventListener(event, handler, { passive: true });
    }

    // Замени стандартные addEventListener
    document.addEventListener('DOMContentLoaded', function () {
        console.log('📄 DOM Content Loaded');
        setTimeout(initializeOwlCarousels, 300);
    }, { passive: true });
}
