/**
 * Main JavaScript
 * File: assets/js/main.js
 */

(function ($) {
    "use strict";

    // Preloader
    $(window).on('load', function () {
        $('#preloader').fadeOut(1000);
    });

    // Initialize AOS Animation
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Back to Top Button
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 300) {
            $('#backToTop').addClass('active');
        } else {
            $('#backToTop').removeClass('active');
        }
    });

    $('#backToTop').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 800);
    });

    // Sticky Header
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 100) {
            $('.header').addClass('sticky');
        } else {
            $('.header').removeClass('sticky');
        }
    });

    // Mobile Menu Toggle
    $('.navbar-toggler').on('click', function () {
        $(this).toggleClass('active');
    });

    // Dropdown Menu for Mobile
    $('.dropdown-toggle').on('click', function (e) {
        if ($(window).width() < 992) {
            e.preventDefault();
            $(this).next('.dropdown-menu').slideToggle();
        }
    });

    // Search Form Toggle
    $('.search-toggle').on('click', function (e) {
        e.preventDefault();
        $('.search-form-wrapper').addClass('active');
    });

    $('.search-close').on('click', function (e) {
        e.preventDefault();
        $('.search-form-wrapper').removeClass('active');
    });

    // Close search form on escape key
    $(document).on('keyup', function (e) {
        if (e.key === "Escape") {
            $('.search-form-wrapper').removeClass('active');
        }
    });

    // Hero Slider
    $('.slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 5000,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    arrows: false
                }
            }
        ]
    });

    // Testimonial Carousel
    $('.testimonial-carousel').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        arrows: false,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    // Initialize Magnific Popup for Gallery
    $('.gallery-popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300
        }
    });

    // Counter Animation
    $('.counter').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 3000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    // Gallery Isotope Filtering
    var $gallery = $('.gallery-grid');
    $gallery.imagesLoaded(function () {
        $gallery.isotope({
            itemSelector: '.gallery-item',
            layoutMode: 'fitRows'
        });
    });

    $('.gallery-filter button').on('click', function () {
        var filterValue = $(this).attr('data-filter');
        $gallery.isotope({
            filter: filterValue
        });
        $('.gallery-filter button').removeClass('active');
        $(this).addClass('active');
    });

    // Form Validation
    $('form').each(function() {
        $(this).validate({
            errorElement: 'span',
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            submitHandler: function(form) {
                // Display loading state
                var submitBtn = $(form).find('button[type="submit"]');
                var originalText = submitBtn.text();
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
                submitBtn.prop('disabled', true);
                
                // Submit form via AJAX
                $.ajax({
                    type: $(form).attr('method'),
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    success: function(response) {
                        var result = JSON.parse(response);
                        
                        if (result.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: result.message,
                                confirmButtonColor: '#38a89d'
                            }).then(function() {
                                if (result.redirect) {
                                    window.location.href = result.redirect;
                                } else {
                                    // Reset form
                                    form.reset();
                                    $(form).find('.is-valid').removeClass('is-valid');
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: result.message,
                                confirmButtonColor: '#38a89d'
                            });
                        }
                        
                        // Restore button state
                        submitBtn.html(originalText);
                        submitBtn.prop('disabled', false);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi. Vui lòng thử lại sau.',
                            confirmButtonColor: '#38a89d'
                        });
                        
                        // Restore button state
                        submitBtn.html(originalText);
                        submitBtn.prop('disabled', false);
                    }
                });
                
                return false;
            }
        });
    });

    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Initialize popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

    // Flash Messages
    if ($('.flash-message').length > 0) {
        setTimeout(function() {
            $('.flash-message').fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    }

})(jQuery);
