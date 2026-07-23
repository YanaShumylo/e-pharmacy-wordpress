<?php

if (!defined('ABSPATH')) {
    exit;
}

// кастомна форма реєстрації
function custom_register_form_shortcode()
{
    ob_start();

    if (isset($_POST['custom_register'])) {

        if (
            !isset($_POST['custom_register_nonce']) ||
            !wp_verify_nonce(
                sanitize_text_field(wp_unslash($_POST['custom_register_nonce'])),
                'custom_register_action'
            )
        ) {

            echo '<div class="register-error">';
            echo esc_html__('Security check failed.', 'generatepress');
            echo '</div>';

            return ob_get_clean();
        }

        $username = isset($_POST['username'])
            ? sanitize_user(trim(wp_unslash($_POST['username'])))
            : '';

        $email = isset($_POST['email'])
            ? sanitize_email(wp_unslash($_POST['email']))
            : '';

        $phone = isset($_POST['phone'])
            ? sanitize_text_field(wp_unslash($_POST['phone']))
            : '';

        $password = isset($_POST['password'])
            ? wp_unslash($_POST['password'])
            : '';

        $errors = [];

        if (empty($username)) {
            $errors[] = __('Please enter username.', 'generatepress');
        }

        if (empty($email) || !is_email($email)) {
            $errors[] = __('Please enter a valid email address.', 'generatepress');
        }

        if (email_exists($email)) {
            $errors[] = __('Email already exists.', 'generatepress');
        }

        if (empty($password)) {
            $errors[] = __('Please enter password.', 'generatepress');
        }

        if (strlen($password) < 8) {
            $errors[] = __('Password must contain at least 8 characters.', 'generatepress');
        }

        if (!empty($phone) && !preg_match('/^[0-9+\-\s()]{8,20}$/', $phone)) {
            $errors[] = __('Please enter a valid phone number.', 'generatepress');
        }

        if (empty($errors)) {

            $user_id = wc_create_new_customer(
                $email,
                $username,
                $password
            );

            if (!is_wp_error($user_id)) {

                update_user_meta(
                    $user_id,
                    'phone',
                    $phone
                );

                // автоматична авторизація
                wp_set_auth_cookie($user_id);

                wp_safe_redirect(
                    wc_get_page_permalink('myaccount')
                );

                exit;
            } else {

                echo '<div class="register-error">';
                echo esc_html($user_id->get_error_message());
                echo '</div>';
            }
        } else {

            foreach ($errors as $error) {

                echo '<div class="register-error">';
                echo esc_html($error);
                echo '</div>';
            }
        }
    }
?>

    <form class="custom-register-form" method="post" novalidate>

        <?php
        wp_nonce_field(
            'custom_register_action',
            'custom_register_nonce'
        );
        ?>

        <div class="wrapper-input">

            <label for="register-username" class="screen-reader-text">
                <?php esc_html_e('Username', 'generatepress'); ?>
            </label>

            <input
                id="register-username"
                class="input-form"
                type="text"
                name="username"
                placeholder="Username"
                autocomplete="username"
                maxlength="60"
                required>

            <label for="register-email" class="screen-reader-text">
                <?php esc_html_e('Email address', 'generatepress'); ?>
            </label>

            <input
                id="register-email"
                class="input-form"
                type="email"
                name="email"
                placeholder="Email address"
                autocomplete="email"
                maxlength="100"
                required>

            <label for="register-phone" class="screen-reader-text">
                <?php esc_html_e('Phone number', 'generatepress'); ?>
            </label>

            <input
                id="register-phone"
                class="input-form"
                type="tel"
                name="phone"
                placeholder="Phone number"
                autocomplete="tel"
                maxlength="20">

            <label for="register-password" class="screen-reader-text">
                <?php esc_html_e('Password', 'generatepress'); ?>
            </label>

            <input
                id="register-password"
                class="input-form"
                type="password"
                name="password"
                placeholder="Password"
                autocomplete="new-password"
                minlength="8"
                required>

        </div>

        <button
            class="btn-form"
            type="submit"
            name="custom_register"
            aria-label="<?php esc_attr_e('Register', 'generatepress'); ?>">
            <?php esc_html_e('Register', 'generatepress'); ?>
        </button>

    </form>

<?php

    return ob_get_clean();
}

add_shortcode(
    'custom_register_form',
    'custom_register_form_shortcode'
);
