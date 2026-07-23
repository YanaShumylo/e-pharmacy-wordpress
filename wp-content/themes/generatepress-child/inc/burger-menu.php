<?php
//  функцію закриття бургер меню
function epharmacy_enqueue_burger_menu()
{

    wp_enqueue_script(
        'epharmacy-burger-menu',
        get_stylesheet_directory_uri() . '/assets/js/burger-menu.js',
        [],
        '1.0',
        true
    );
}

add_action(
    'wp_enqueue_scripts',
    'epharmacy_enqueue_burger_menu'
);
