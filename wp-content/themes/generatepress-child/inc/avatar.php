<?php
// виведення аватарки
add_shortcode('user_avatar', function () {
    return get_avatar(get_current_user_id(), 44);
});