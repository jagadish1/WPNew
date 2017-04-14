<?php
$form_id = $id;

$results_columns = $columns;

$classes = array();

$classes[]='wcf-item-result';
$classes[]='wcf-column-' . $results_columns;

if (have_posts()) :
    ?>
    <?php if (is_search()) { ?>
        <header class="wcf-page-header">
            <h2 class="wcf-page-title"><?php printf( __( 'Search Results for: %s', WORDPRESS_CONTENT_FILTER_LANG ), '<span>' . get_search_query() . '</span>' ); ?></h2>
        </header>
    <?php } ?>

    <ul class="wcf-row wcf-items-results wcf-items-woo">
        <?php
        $count_item = 0;
        while (have_posts()) : the_post();
            ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
                <div class="wcf-product-inner">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <div class="product-image">
                            <?php
                            wc_get_template( 'loop/sale-flash.php' );
                            woocommerce_template_loop_product_thumbnail();
                            ?>
                        </div>

                        <h3><?php the_title(); ?></h3>
                        <?php wc_get_template( 'loop/rating.php' );?>
                        <?php wc_get_template( 'loop/price.php' ); ?>
                    </a>
                </div>
            </li>
            <?php
            $count_item++;
            if ($count_item%$results_columns == 0) {?>
                <div class="wcf-clear"></div>
            <?php } ?>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <h2><?php _e( 'Sorry, not found.', WORDPRESS_CONTENT_FILTER_LANG ); ?></h2>
<?php endif; ?>
