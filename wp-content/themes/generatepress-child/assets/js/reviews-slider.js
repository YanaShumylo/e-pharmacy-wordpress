document.addEventListener('DOMContentLoaded', function () {

    const container = document.querySelector('.reviews-grid');
    if (!container) return;

    if (container.classList.contains('swiper-initialized')) return;

    const wrapper = container.querySelector('.wp-block-post-template');
    if (!wrapper) return;

    wrapper.classList.add('swiper-wrapper');

    wrapper.querySelectorAll(':scope > li').forEach(item => {
        item.classList.add('swiper-slide');
    });

    container.classList.add('swiper');

    const swiper = new Swiper(container, {

        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,

        pagination: {
            el: '.reviews-pagination',
            clickable: true,
        },

        navigation: {
            nextEl: '.reviews-button-next',
            prevEl: '.reviews-button-prev',
        },

        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 24
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 32
            }
        }
    });
});