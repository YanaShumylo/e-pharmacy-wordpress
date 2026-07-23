<?php

if (!defined('ABSPATH')) {
    exit;
}
// styles + scripts
require_once get_stylesheet_directory() . '/inc/enqueue.php';

// burger
require_once get_stylesheet_directory() . '/inc/burger-menu.php';

// slider
require_once get_stylesheet_directory() . '/inc/reviews-slider.php';

// avatar
require_once get_stylesheet_directory() . '/inc/avatar.php';

// logout
require_once get_stylesheet_directory() . '/inc/logout.php';

add_action('wp', function () { 
    // список аптек на домашній сторінці
    if (is_front_page()) {
        require_once get_stylesheet_directory() . '/inc/stores.php';
    } 
    // сторінка Medicine 
    if (is_page('medicine')) {
        require_once get_stylesheet_directory() . '/inc/medicine.php';
    } 
    // сторінка Medicine stores 
    if (is_page('medicine-store')) {
        require_once get_stylesheet_directory() . '/inc/medicine-stores.php';
    } 
});

// сторінка Реєстрація 
require_once get_stylesheet_directory() . '/inc/register-form.php';

// сторінка Логін 
require_once get_stylesheet_directory() . '/inc/login-form.php';

// підключаємо хедера для виведення на всіх сторінках
add_action('generate_before_header', function () {
    get_template_part('template-parts/header');
});

// відключаємо стандарний футер
add_action('after_setup_theme', function () {
    remove_action('generate_footer', 'generate_construct_footer');
});

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'wp_generator');

function medicine_enqueue_scripts()
{

    wp_enqueue_script(
        'pop-up',
        get_stylesheet_directory_uri() . '/assets/js/pop-up.js',
        array('jquery'),
        '1.0',
        true
    );

    wp_localize_script(
        'pop-up',
        'medicineCart',
        array(
            'isLoggedIn'   => is_user_logged_in(),
            'loginPopup'   => 1916,
            'registerPopup' => 1937,
            'ajaxUrl'      => WC_AJAX::get_endpoint('add_to_cart'),
        )
    );
}

add_action('wp_enqueue_scripts', 'medicine_enqueue_scripts');
