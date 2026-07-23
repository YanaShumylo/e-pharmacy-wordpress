<?php

if (!defined('ABSPATH')) {
    exit;
}

// логаут
function custom_logout_link()
{
    return sprintf(
        '<a class="gb-text btn-logout" href="%s">Log out</a>',
        esc_url(wp_logout_url(home_url('/')))
    );
}

add_shortcode('custom_logout', 'custom_logout_link');
