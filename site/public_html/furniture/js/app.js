$(function () {
    "use strict";

    $('.owl-carousel').owlCarousel({
        slideSpeed : 300,
        loop: true,
        margin: 10,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
        }
    })
});