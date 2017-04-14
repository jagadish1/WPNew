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
    <div class="wcf-row wcf-items-results wcf-items-edd">
        <?php
        $count_item = 0;
        while (have_posts()) : the_post();

            ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
                <div class="edd_download_inner">
                    <?php

                    do_action( 'edd_download_before' );

                    edd_get_template_part( 'shortcode', 'content-image' );
                    do_action( 'edd_download_after_thumbnail' );


                    edd_get_template_part( 'shortcode', 'content-title' );
                    do_action( 'edd_download_after_title' );

//                    edd_get_template_part( 'shortcode', 'content-price' );
                    ?>
                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <div itemprop="price" class="edd_price">
                            <?php edd_price( get_the_ID() ); ?>
                        </div>
                    </div>
                    <?php
                    do_action( 'edd_download_after_price' );


                    do_action( 'edd_download_after' );
                    ?>
                </div>
            </div>
            <?php
            $count_item++;
            if ($count_item%(int)$results_columns == 0) {?>
                <div class="wcf-clear"></div>
            <?php } ?>
        <?php endwhile; ?>
    </div>

<?php else: ?>

    <h2><?php _e( 'Sorry, not found.', WORDPRESS_CONTENT_FILTER_LANG ); ?></h2>

<?php endif; ?>
