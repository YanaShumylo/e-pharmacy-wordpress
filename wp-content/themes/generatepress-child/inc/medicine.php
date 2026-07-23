<?php

if (!defined('ABSPATH')) {
    exit;
}

// сторінка Medicine (фільтрація, пошук, список товарів, пагінація)
function medicine()
{
    ob_start();

    $paged = max(
        1,
        get_query_var('paged'),
        get_query_var('page'),
        isset($_GET['paged'])
            ? absint($_GET['paged'])
            : 1
    );

    // фільтрація
    $category = isset($_GET['med_cat'])
        ? sanitize_text_field(
            wp_unslash($_GET['med_cat'])
        )
        : '';

    $search = isset($_GET['med_search'])
        ? sanitize_text_field(
            wp_unslash($_GET['med_search'])
        )
        : '';

?>

    <div class="medicine-products-filter">

        <form
            method="get"
            action="<?php echo esc_url(get_permalink()); ?>"
            class="medicine-filter-form">

            <div class="medicine-select-wrap">

                <label
                    for="medicine-category"
                    class="screen-reader-text">
                    <?php esc_html_e('Product category', 'generatepress'); ?>
                </label>

                <select
                    id="medicine-category"
                    name="med_cat"
                    aria-label="<?php esc_attr_e('Product category', 'generatepress'); ?>">

                    <option value="">
                        <?php esc_html_e('Product category', 'generatepress'); ?>
                    </option>

                    <?php

                    $categories = get_transient(
                        'medicine_product_categories'
                    );

                    if ($categories === false) {

                        $categories = get_terms([
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                        ]);

                        if (!is_wp_error($categories)) {

                            set_transient(
                                'medicine_product_categories',
                                $categories,
                                DAY_IN_SECONDS
                            );
                        }
                    }


                    if (!is_wp_error($categories) && !empty($categories)) :

                        foreach ($categories as $cat) :

                    ?>
                            <option
                                value="<?php echo esc_attr($cat->slug); ?>"
                                <?php selected($category, $cat->slug); ?>>

                                <?php echo esc_html($cat->name); ?>

                            </option>


                    <?php

                        endforeach;

                    endif;

                    ?>


                </select>

                <span
                    class="medicine-select-icon"
                    aria-hidden="true">

                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none">

                        <path
                            d="M4 6L8 10L12 6"
                            stroke="#1D1E21"
                            stroke-width="1.5"
                            stroke-linecap="round" />
                    </svg>
                </span>

            </div>

            <div class="medicine-search-wrap">
                <label
                    for="medicine-search"
                    class="screen-reader-text">
                    <?php esc_html_e('Search medicine', 'generatepress'); ?>
                </label>

                <input
                    id="medicine-search"
                    type="search"
                    name="med_search"
                    placeholder="Search medicine"
                    value="<?php echo esc_attr($search); ?>"
                    autocomplete="search">

                <span
                    class="medicine-search-icon"
                    aria-hidden="true">

                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none">

                        <path
                            d="M7.33333 12.6667C10.2789 12.6667 12.6667 10.2789 12.6667 7.33333C12.6667 4.38781 10.2789 2 7.33333 2C4.38781 2 2 4.38781 2 7.33333C2 10.2789 4.38781 12.6667 7.33333 12.6667Z"
                            stroke="#1D1E21"
                            stroke-width="1.5" />

                        <path
                            d="M14.0016 13.9996L11.1016 11.0996"
                            stroke="#1D1E21"
                            stroke-width="1.5" />
                    </svg>
                </span>

            </div>

            <button
                type="submit"
                aria-label="<?php esc_attr_e('Filter products', 'generatepress'); ?>">

                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.8307 1.75H1.16406L5.83073 7.26833V11.0833L8.16406 12.25V7.26833L12.8307 1.75Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                <?php esc_html_e('Filter', 'generatepress'); ?>

            </button>

            <?php if ($category || $search) : ?>
                <a
                    href="<?php echo esc_url(
                                remove_query_arg([
                                    'med_cat',
                                    'med_search',
                                    'paged'
                                ])
                            ); ?>">
                    <?php esc_html_e('Reset', 'generatepress'); ?>
                </a>

            <?php endif; ?>
        </form>
    </div>
    <?php
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    if (!empty($search)) {

        $args['s'] = $search;
    }

    if (!empty($category)) {

        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category,
            ]
        ];
    }

    $products = new WP_Query($args);

    if ($products->have_posts()) :
        echo '<ul class="container-product">';

        while ($products->have_posts()) :

            $products->the_post();

            global $product;
    ?>


            <li class="product-cart">
                <div class="product-card-image">
                    <?php
                    if ($product) {
                        echo wp_kses_post(
                            $product->get_image(
                                'woocommerce_thumbnail'
                            )
                        );
                    }
                    ?>
                </div>

                <div class="product-card-content">
                    <h4 class="product-title">
                        <?php
                        echo esc_html(
                            get_the_title()
                        );
                        ?>
                    </h4>

                    <div class="product-price">
                        <?php
                        if ($product) {
                            echo wp_kses_post(
                                $product->get_price_html()
                            );
                        }
                        ?>
                    </div>

                    <?php
                    $brands = get_the_terms(get_the_ID(), 'product_brand');

                    if ($brands && ! is_wp_error($brands)) : ?>
                        <div class="product-brand">
                            <?php echo esc_html($brands[0]->name); ?>
                        </div>
                    <?php endif; ?>

                    <div class="product-buttons">
                        <?php if (is_user_logged_in()) : ?>

                            <?php woocommerce_template_loop_add_to_cart(); ?>

                        <?php else : ?>

                            <a
                                href="#"
                                class="button login-required-add-to-cart"
                                data-product-id="<?php echo esc_attr($product->get_id()); ?>"
                                aria-label="<?php echo esc_attr(
                                                sprintf(
                                                    __('Add %s to cart', 'generatepress'),
                                                    get_the_title()
                                                )
                                            ); ?>">
                                <?php esc_html_e('Add to cart', 'woocommerce'); ?>
                            </a>

                        <?php endif; ?>

                        <a
                            class="product-details-btn"
                            href="<?php echo esc_url(get_permalink()); ?>"
                            aria-label="<?php echo esc_attr(
                                            sprintf(
                                                __('View details about %s', 'generatepress'),
                                                get_the_title()
                                            )
                                        ); ?>">
                            <?php esc_html_e('Details', 'generatepress'); ?>
                        </a>
                    </div>
                </div>
            </li>

<?php
        endwhile;
        echo '</ul>';

        // пагінація
        if ($products->max_num_pages > 1) :
            echo '<nav class="medicine-pagination" aria-label="' .
                esc_attr__('Products pagination', 'generatepress') .
                '">';
            echo '<ul>';
            // перша сторінка
            echo '<li>';
            echo '<a class="pagination-arrow" href="' .
                esc_url(add_query_arg('paged', 1)) .
                '" aria-label="' .
                esc_attr__('First page', 'generatepress') .
                '">«</a>';
            echo '</li>';

            // попередня сторінка

            echo '<li>';
            echo '<a class="pagination-arrow" href="' .
                esc_url(
                    add_query_arg(
                        'paged',
                        max(1, $paged - 1)
                    )
                ) .
                '" aria-label="' .
                esc_attr__('Previous page', 'generatepress') .
                '">‹</a>';

            echo '</li>';

            $pagination = paginate_links([
                'base' => add_query_arg(
                    'paged',
                    '%#%'
                ),

                'format'      => '',
                'current'     => $paged,
                'total'       => $products->max_num_pages,
                'mid_size'    => 1,
                'end_size'    => 1,
                'type'        => 'array',
                'prev_next'   => false,
            ]);

            if ($pagination) {

                foreach ($pagination as $page) {
                    echo '<li>';
                    echo wp_kses_post($page);
                    echo '</li>';
                }
            }

            // наступна сторінка
            echo '<li>';
            echo '<a class="pagination-arrow" href="' .
                esc_url(
                    add_query_arg(
                        'paged',
                        min(
                            $products->max_num_pages,
                            $paged + 1
                        )
                    )
                ) .
                '" aria-label="' .
                esc_attr__('Next page', 'generatepress') .
                '">›</a>';
            echo '</li>';

            // наступна сторінка
            echo '<li>';
            echo '<a class="pagination-arrow" href="' .
                esc_url(
                    add_query_arg(
                        'paged',
                        $products->max_num_pages
                    )
                ) .
                '" aria-label="' .
                esc_attr__('Last page', 'generatepress') .
                '">»</a>';
            echo '</li>';
            echo '</ul>';
            echo '</nav>';
        endif;
    else :
        echo '<p>';
        esc_html_e(
            'Nothing was found for your request.',
            'generatepress'
        );
        echo '</p>';
    endif;
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode(
    'medicine_products',
    'medicine'
);
