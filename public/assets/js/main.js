document.addEventListener('DOMContentLoaded', function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    Livewire.on('showToast', (event) => {
        const message = event.message || 'Операция выполнена';
        const type = event.type || 'info';

        if (toastr[type]) {
            toastr[type](message);
        } else {
            toastr.info(message);
        }
    });

    Livewire.on('cart-updated', (event) => {
        console.log('Cart updated');
    });
});

$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('#top').fadeIn();
        } else {
            $('#top').fadeOut();
        }
    });
});
