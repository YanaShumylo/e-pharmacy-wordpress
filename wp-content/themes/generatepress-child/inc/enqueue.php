<?php if (!defined('ABSPATH')) {
    exit;
}
add_action('wp_enqueue_scripts', function () {
    
    wp_enqueue_style('generatepress-parent', get_template_directory_uri() . '/style.css');
    
    // стилі для слайдера на сторінці Home
    if (is_front_page() || is_page('reviews')) {
        $file = get_stylesheet_directory() . '/assets/css/slider.css';
        if (file_exists($file)) {
            wp_enqueue_style('epharmacy-slider', get_stylesheet_directory_uri() . '/assets/css/slider.css', ['generatepress-parent'], filemtime($file));
        }
    }

    // стилі для форми реєстрації, логіну на сторінках реєстрації, логіну та medicine (pop-up)
    if (
        is_page(['register', 'login', 'medicine'])
    ) {
        $file = get_stylesheet_directory() . '/assets/css/register-form.css';
        if (file_exists($file)) {
            wp_enqueue_style(
                'epharmacy-register-form',
                get_stylesheet_directory_uri() . '/assets/css/register-form.css',
                ['generatepress-parent'],
                filemtime($file)
            );
        }

        $file = get_stylesheet_directory() . '/assets/css/login-form.css';
        if (file_exists($file)) {
            wp_enqueue_style(
                'epharmacy-login-form',
                get_stylesheet_directory_uri() . '/assets/css/login-form.css',
                ['generatepress-parent'],
                filemtime($file)
            );
        }
    }

    // стилі для пагінації на сторінці Medicine stores
    if (is_page('medicine-store')) {
        $file = get_stylesheet_directory() . '/assets/css/medicine-stores.css';
        if (file_exists($file)) {
            wp_enqueue_style('medicine-stores', get_stylesheet_directory_uri() . '/assets/css/medicine-stores.css', ['generatepress-parent'], filemtime($file));
        }
    }

    // стилі дня фільтрації, пошуку, списку та пагінації на сторінці Medicine
    if (is_page('medicine')) {
        $file = get_stylesheet_directory() . '/assets/css/medicine.css';
        if (file_exists($file)) {
            wp_enqueue_style('medicine', get_stylesheet_directory_uri() . '/assets/css/medicine.css', ['generatepress-parent'], filemtime($file));
        }
    }
});