<?php
get_header();
?>

<div class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <span class="caption d-block mb-2 font-secondary font-weight-bold">Testimonials</span>
                <h2 class="site-section-heading text-uppercase text-center font-secondary">Happy Customers</h2>
            </div>
        </div>
        <div class="row">

            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $postsPerpage = get_option('testimonials_per_page');
            if (!$postsPerpage || is_nan($postsPerpage))
                $postsPerpage = 10;
            $args = [
                'posts_per_page' => $postsPerpage,
                'orderby' => 'date',
                'order' => 'ASC',
                'post_type' => 'testimonials',
                'fields' => ['ID'],
                'paged' => $paged
            ];
            $testimonials = new WP_Query( $args );

            if ($testimonials->have_posts())
                while( $testimonials->have_posts() ) {
                    $testimonials->the_post();
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                    $imageAlt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(get_post_thumbnail_id()) ?: 'Tasyakur ID\'s image asset';
                    ?>

                    <div class="col-md-6 col-lg-6 mb-4">
                        <div class="d-block block-testimony mx-auto text-center">
                            <?
                            if ($image[0]) :
                                ?>
                                <div class="person w-25 mx-auto mb-4">
                                    <img src="<?=$image[0]?>" alt="<?=$imageAlt?>" class="img-fluid rounded-circle w-50 mx-auto">
                                </div>
                            <?
                            endif;
                            ?>
                            <div>
                                <h2 class="h5 mb-4"><?=get_field('customer_name')?></h2>
                                <blockquote>&ldquo;<?=get_field('testimony')?>&rdquo;</blockquote>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <?php
                pagination($testimonials);
                ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>
