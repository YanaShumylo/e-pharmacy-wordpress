<?php
// слайдер для відгуків
function pharmacy_reviews_slider_assets()
{

    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        null
    );

    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'reviews-slider',
        get_stylesheet_directory_uri() . '/assets/js/reviews-slider.js',
        ['swiper-js'],
        '1.0',
        true
    );
}

add_action(
    'wp_enqueue_scripts',
    'pharmacy_reviews_slider_assets'
);
