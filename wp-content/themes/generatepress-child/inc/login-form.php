<?php

if (!defined('ABSPATH')) {
    exit;
}

// кастомна форма логіну 
function custom_login_form_shortcode()
{
    ob_start();

    if (isset($_POST['custom_login'])) {

        if (
            !isset($_POST['custom_login_nonce']) ||
            !wp_verify_nonce(
                sanitize_text_field(wp_unslash($_POST['custom_login_nonce'])),
                'custom_login_action'
            )
        ) {
            echo '<div class="login-error">' . esc_html__('Security check failed.', 'generatepress') . '</div>';

            return ob_get_clean();
        }

        $email = isset($_POST['email'])
            ? sanitize_email(wp_unslash($_POST['email']))
            : '';

        $password = isset($_POST['password'])
            ? wp_unslash($_POST['password'])
            : '';

        $errors = [];

        if (empty($email) || !is_email($email)) {
            $errors[] = __('Please enter a valid email address.', 'generatepress');
        }

        if (empty($password)) {
            $errors[] = __('Please enter your password.', 'generatepress');
        }

        if (empty($errors)) {

            $user = get_user_by('email', $email);

            if (!$user) {

                echo '<div class="login-error">';
                echo esc_html__('User not found.', 'generatepress');
                echo '</div>';
            } else {

                $credentials = [
                    'user_login'    => $user->user_login,
                    'user_password' => $password,
                    'remember'      => true,
                ];

                $login = wp_signon($credentials, false);

                if (is_wp_error($login)) {

                    echo '<div class="login-error">';
                    echo esc_html($login->get_error_message());
                    echo '</div>';
                } else {

                    wp_safe_redirect(
                        wc_get_page_permalink('myaccount')
                    );
                    exit;
                }
            }
        } else {

            foreach ($errors as $error) {

                echo '<div class="login-error">';
                echo esc_html($error);
                echo '</div>';
            }
        }
    }
?>

    <form class="custom-login-form" method="post" novalidate>

        <?php
        wp_nonce_field(
            'custom_login_action',
            'custom_login_nonce'
        );
        ?>

        <div class="wrapper-input">

            <label for="login-email" class="screen-reader-text">
                <?php esc_html_e('Email address', 'generatepress'); ?>
            </label>

            <input
                id="login-email"
                class="input-form"
                type="email"
                name="email"
                placeholder="Email address"
                autocomplete="email"
                required>

            <label for="login-password" class="screen-reader-text">
                <?php esc_html_e('Password', 'generatepress'); ?>
            </label>

            <input
                id="login-password"
                class="input-form"
                type="password"
                name="password"
                placeholder="Password"
                autocomplete="current-password"
                required>

        </div>

        <button
            class="btn-form"
            type="submit"
            name="custom_login"
            aria-label="<?php esc_attr_e('Log in', 'generatepress'); ?>">
            <?php esc_html_e('Log in', 'generatepress'); ?>
        </button>

    </form>

<?php

    return ob_get_clean();
}

add_shortcode(
    'custom_login_form',
    'custom_login_form_shortcode'
);
