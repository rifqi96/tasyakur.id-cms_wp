<div class="site-section <?=(isset($featuredImage) && $featuredImage) ? 'pt-0' : 'pt-5'?>" data-aos="fade">
    <?php
    if (isset($featuredImage) && $featuredImage) {
        ?>
    <div class="page-blocks-cover site-blocks-cover inner-page overlay aos-init aos-animate mb-3"
         data-aos="fade"
         style="background-image: url(<?=$featuredImage?>);">
        <div class="row cover-title align-items-center justify-content-center">
            <div class="col-md-5 aos-init aos-animate" data-aos="fade">
                <h1 class="site-section-heading text-center text-uppercase"><?=$theTitle ?? 'Products'?></h1>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="container">
        <?php
        if (!isset($featuredImage) || !$featuredImage) {
            ?>
        <div class="row mb-5">
            <div class="col-md-12" data-aos="fade">
                <h2 class="site-section-heading text-center text-uppercase"><?=$theTitle ?? 'Products'?></h2>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="row mb-5">
            <div class="col-auto mr-auto">
                <?php
                wp_nav_menu([
                    'menu'            => 'products-category',
                    'theme_location'  => 'products-category-menu',
                    'container'       => '',
                    'menu_id'         => false,
                    'menu_class'      => 'nav',
                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => new ProductsCategoryMenuWalker(),
                ]);
                ?>
            </div>
            <div class="col-auto">
                <? get_template_part('template-parts/component', 'searchform'); ?>
            </div>
        </div>
        <div class="row mb-5">
            <?php
            /** @var $args array */

            $products = new WP_Query( $args );

            if ($products->have_posts())
                while($products->have_posts()) {
                    $products->the_post();
                    setup_postdata( $post );
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                    $imageAlt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(get_post_thumbnail_id()) ?: 'Tasyakur ID\'s image asset';
                    $price = get_field('product_price');
                    ?>
                    <div class="col-md-6 col-lg-3 mb-5">
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
                    </div>

                    <?php
                }
            ?>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <?php
                pagination($products);
                ?>
            </div>
        </div>
    </div>
</div>