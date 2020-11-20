<!-- Products List -->
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12" data-aos="fade">
                <h2 class="site-section-heading text-uppercase">Related Products</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 block-13 nav-direction-white">
                <div class="nonloop-block-13 owl-carousel">
                    <?php
                    global $post;
                    $categories = wp_get_post_terms($post->ID, 'products_category');
                    $categoryIDs = [];
                    if ($categories)
                        $categoryIDs = array_map(function($cat) {
                            return $cat->term_id ?? '';
                        }, $categories);

                    $products = get_posts([
                        'posts_per_page' => 5,
                        'orderby' => 'date',
                        'order' => 'ASC',
                        'post_type' => 'products',
                        'fields' => ['ID'],
                        'post__not_in' => [ $post->ID ],
                        'tax_query' => [
                            [
                                'taxonomy' => 'products_category', //or tag or custom taxonomy
                                'field' => 'term_id',
                                'terms' => $categoryIDs,
                            ]
                        ],
                    ]);

                    if ($products)
                        foreach($products as $post) {
                            setup_postdata( $post );
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                            $imageAlt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(get_post_thumbnail_id()) ?: 'Tasyakur ID\'s image asset';
                            $price = get_field('product_price');
                            ?>

                            <div class="media-image">
                                <a href="<?the_permalink()?>">
                                    <img src="<?=esc_url($image[0])?>" alt="<?=$imageAlt?>" class="featured-img img-fluid">
                                </a>
                                <div class="media-image-body">
                                    <h2 class="font-secondary text-uppercase"><?=the_title()?></h2>
                                    <p class="currency"><?=$price?></p>
                                    <p><a href="<?php the_permalink(); ?>" class="btn btn-primary text-white px-4">Details</a></p>
                                </div>
                            </div>

                            <?php
                        }

                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>