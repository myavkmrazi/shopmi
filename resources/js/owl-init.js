console.log('🦉 owl-init.js loaded');

let initializationInProgress = false;
let initializationAttempts = 0;
const MAX_ATTEMPTS = 3;

function initializeAllOwlCarousels() {
    if (initializationInProgress) {
        console.log('⏩ Initialization already in progress');
        return;
    }

    initializationInProgress = true;
    initializationAttempts++;

    console.log('🚀 Initializing Owl Carousels...');

    const carousels = document.querySelectorAll('.owl-carousel');
    console.log('Found carousels:', carousels.length);

    if (carousels.length === 0) {
        console.log('❌ No carousels found');
        initializationInProgress = false;

        if (initializationAttempts < MAX_ATTEMPTS) {
            setTimeout(initializeAllOwlCarousels, 500);
        }
        return;
    }

    if (typeof window.jQuery === 'undefined') {
        console.log('❌ jQuery not available');
        initializationInProgress = false;

        if (initializationAttempts < MAX_ATTEMPTS) {
            setTimeout(initializeAllOwlCarousels, 200);
        }
        return;
    }

    if (typeof window.jQuery.fn.owlCarousel === 'undefined') {
        console.log('❌ Owl Carousel plugin not available');
        initializationInProgress = false;

        if (initializationAttempts < MAX_ATTEMPTS) {
            setTimeout(initializeAllOwlCarousels, 200);
        }
        return;
    }

    try {
        let initializedCount = 0;

        carousels.forEach((carousel, index) => {
            const $carousel = window.jQuery(carousel);

            if ($carousel.hasClass('owl-loaded')) {
                console.log(`⏩ Carousel ${index + 1} already initialized`);
                initializedCount++;
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
                    1000: { items: 4 },
                    1400: { items: 5 },
                    1800: { items: 6 }
                }
            });

            console.log(`✅ Carousel ${index + 1} initialized`);
            initializedCount++;
        });

        console.log(`🎉 Successfully initialized ${initializedCount}/${carousels.length} carousels`);
        initializationInProgress = false;

    } catch (error) {
        console.error('❌ Error initializing carousels:', error);
        initializationInProgress = false;
    }
}

window.addEventListener('load', function () {
    console.log('📄 Page fully loaded');
    setTimeout(initializeAllOwlCarousels, 100);
});

if (typeof Livewire !== 'undefined') {
    console.log('🔌 Livewire detected');

    let livewireTimeout;
    Livewire.hook('morph.updated', () => {
        console.log('🔄 Livewire component updated');

        clearTimeout(livewireTimeout);
        livewireTimeout = setTimeout(() => {
            initializationAttempts = 0;
            initializeAllOwlCarousels();
        }, 400); 
    });
}
