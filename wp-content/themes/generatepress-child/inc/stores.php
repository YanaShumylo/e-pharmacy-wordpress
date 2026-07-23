<?php

if (!defined('ABSPATH')) {
    exit;
}

// список аптек на головній сторінці
function stores_list_shortcode()
{
    ob_start();
    $stores = new WP_Query([
        'post_type'      => 'stores',
        'posts_per_page' => 6,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ]);

    if ($stores->have_posts()) :
        echo '<div class="wp-block-query stores-grid">';
        echo '<ul class="stores-list">';

        while ($stores->have_posts()) :

            $stores->the_post();

            $store_title = get_the_title();
            $website = get_field('store_website');
            $address = get_field('store_address');
            $phone = get_field('store_phone');
            $rating = get_field('rating');
            $open = get_field('store_open_time');
            $close = get_field('store_close_time');

            // статус відкрито чи закрито
            $is_open = false;

            $now = current_time('H:i');

            if ($open && $close) {

                if ($open < $close) {

                    $is_open = (
                        $now >= $open &&
                        $now <= $close
                    );
                } else {

                    $is_open = (
                        $now >= $open ||
                        $now <= $close
                    );
                }
            }
            
            $map_url = '';
            if ($address) {
                $map_url = add_query_arg(
                    [
                        'api'   => '1',
                        'query' => $address,
                    ],
                    'https://www.google.com/maps/search/'
                );
            }

            $phone_link = '';
            if ($phone) {
                $phone_link = preg_replace(
                    '/\D+/',
                    '',
                    $phone
                );
            }
?>
            <li class="stores-item store-card-link">
                <div class="store-card-left">
                    <div class="store-top">
                        <h3 class="store-title-card">
                            <?php echo esc_html($store_title); ?>
                        </h3>

                        <div class="meta">
                            <svg
                                width="15"
                                height="14"
                                viewBox="0 0 15 14"
                                aria-hidden="true">
                                <path
                                    d="M8.88965 4.12598L13.4746 5.35254L10.7871 8.12012L11.0361 12.8604L7.5752 11.1592L3.14258 12.8604L3.69238 9.04297L0.704102 5.35254L4.50488 4.69629L7.08984 0.714844Z"
                                    fill="#FFC531" />
                            </svg>

                            <?php if ($rating) : ?>
                                <p>
                                    <?php echo esc_html($rating); ?>
                                </p>
                            <?php endif; ?>

                            <?php if ($is_open) : ?>
                                <span class="store-status open">
                                    <?php esc_html_e('Open', 'generatepress'); ?>
                                </span>

                            <?php else : ?>
                                <span class="store-status close">
                                    <?php esc_html_e('Closed', 'generatepress'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="store-content">

                        <?php if ($address) : ?>
                            <div class="adress">
                                <svg
                                    width="18"
                                    height="18"
                                    viewBox="0 0 18 18"
                                    aria-hidden="true">
                                    <path
                                        d="M15.75 7.5C15.75 12.75 9 17.25 9 17.25C9 17.25 2.25 12.75 2.25 7.5C2.25 5.70979 2.96116 3.9929 4.22703 2.72703C5.4929 1.46116 7.20979 0.75 9 0.75C10.7902 0.75 12.5071 1.46116 13.773 2.72703C15.0388 3.9929 15.75 5.70979 15.75 7.5Z"
                                        stroke="#59B17A"
                                        stroke-width="1.5"
                                        fill="none" />
                                    <path
                                        d="M9 9.75C10.2426 9.75 11.25 8.74264 11.25 7.5C11.25 6.25736 10.2426 5.25 9 5.25C7.75736 5.25 6.75 6.25736 6.75 7.5C6.75 8.74264 7.75736 9.75 9 9.75Z"
                                        stroke="#59B17A"
                                        stroke-width="1.5"
                                        fill="none" />
                                </svg>
                                <a
                                    href="<?php echo esc_url($map_url); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    aria-label="<?php echo esc_attr__('Open pharmacy location in Google Maps', 'generatepress'); ?>">
                                    <p>
                                        <?php echo esc_html($address); ?>
                                    </p>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($phone) : ?>
                            <div class="phone">
                                <svg
                                    width="18"
                                    height="18"
                                    viewBox="0 0 18 18"
                                    aria-hidden="true">
                                    <path
                                        d="M16.4981 12.6901V14.9401C16.499 15.1489 16.4562 15.3557 16.3725 15.5471C16.2888 15.7385 16.1661 15.9103 16.0122 16.0515C15.8583 16.1927 15.6765 16.3002 15.4787 16.3671C15.2808 16.434 15.0711 16.4589 14.8631 16.4401C12.5552 16.1893 10.3384 15.4007 8.39062 14.1376C6.57849 12.9861 5.04212 11.4497 3.89062 9.63757C2.6231 7.68098 1.8343 5.45332 1.58812 3.13507C1.56938 2.92767 1.59402 2.71864 1.66049 2.52129C1.72696 2.32394 1.8338 2.14259 1.97419 1.98879C2.11459 1.83499 2.28547 1.7121 2.47596 1.62796C2.66645 1.54382 2.87237 1.50027 3.08062 1.50007H5.33062C5.6946 1.49649 6.04746 1.62538 6.32344 1.86272C6.59942 2.10006 6.77968 2.42966 6.83062 2.79007C6.92559 3.51012 7.10171 4.21712 7.35562 4.89757C7.45653 5.16602 7.47837 5.45776 7.41855 5.73823C7.35873 6.01871 7.21977 6.27616 7.01812 6.48007L6.06562 7.43257C7.13329 9.31023 8.68796 10.8649 10.5656 11.9326L11.5181 10.9801C11.722 10.7784 11.9795 10.6395 12.26 10.5796C12.5404 10.5198 12.8322 10.5417 13.1006 10.6426C13.7811 10.8965 14.4881 11.0726 15.2081 11.1676C15.5724 11.219 15.9052 11.4025 16.143 11.6832C16.3809 11.9639 16.5072 12.3223 16.4981 12.6901Z"
                                        stroke="#59B17A"
                                        stroke-width="1.5"
                                        fill="none" />
                                </svg>

                                <a
                                    href="tel:<?php echo esc_attr($phone_link); ?>"
                                    aria-label="<?php echo esc_attr__('Call pharmacy', 'generatepress'); ?>">
                                    <p>
                                        <?php echo esc_html($phone); ?>
                                    </p>
                                </a>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($website) : ?>
                    <a
                        class="store-card-overlay"
                        href="<?php echo esc_url($website); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="<?php echo esc_attr(
                                        sprintf(
                                            __('Visit %s website', 'generatepress'),
                                            $store_title
                                        )
                                    ); ?>">
                    </a>
                <?php endif; ?>
            </li>

<?php
        endwhile;
        echo '</ul>';
        echo '</div>';
    else :
        echo '<p>';
        esc_html_e(
            'No pharmacies found.',
            'generatepress'
        );
        echo '</p>';
    endif;

    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode(
    'stores',
    'stores_list_shortcode'
);
