<?php
get_header();
?>
    <!-- Sliders -->
    <div class="slide-one-item home-slider owl-carousel">

        <?php
        $sliders = get_field('image_sliders');

        if ($sliders)
            foreach($sliders as $slider) {
                $image = $slider['image'];
                $imageAlt = $image['alt'] ?? 'Tasyakur ID\'s image asset';
                $destinationOption = $slider['destination_option'];
                $html = "<div class='site-blocks-cover inner-page overlay' style='background-image: url($image[url])' alt='$imageAlt'>";
                if (isset($slider['use_text_overlay']) && $slider['use_text_overlay'])
                    $html .=
                        "<div class='container'>
                            <div class='row align-items-center justify-content-center'>
                                <div class='col-md-6 text-center' data-aos='fade'>
                                    <h2 class='font-secondary font-weight-bold text-uppercase'>$slider[text_overlay]</h2>
                                </div>
                            </div>
                        </div>";
                $html .= "</div>";
                $url = '';
                if ($destinationOption === 'Url')
                    $url = $slider['url'];
                else if ($destinationOption === 'Post')
                    $url = get_permalink( $slider['post']->ID );
                if ($destinationOption !== 'Nothing')
                    $html = "<a href='$url'>$html</a>";

                echo $html;
            }
        ?>
    </div>

    <!--    <div class="slant-1"></div>-->

    <!-- Products List -->
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="site-section-heading text-uppercase text-center font-secondary">PRODUCTS</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 block-13 nav-direction-white">
                    <div class="nonloop-block-13 owl-carousel">
                        <?php
                        $products = get_posts([
                            'posts_per_page' => 10,
                            'orderby' => 'date',
                            'order' => 'ASC',
                            'post_type' => 'products',
                            'fields' => ['ID'],
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
                                        <img src="<?=esc_url($image[0])?>" alt="<?=$imageAlt?>" class="img-fluid">
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

    <!-- Recent Blog Posts -->
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12" data-aos="fade">
                    <h2 class="site-section-heading text-center text-uppercase">Recent Blog Posts</h2>
                </div>
            </div>
            <div class="row">
                <?php
                $posts = get_posts([
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'ASC',
                    'post_type' => 'post',
                    'fields' => ['ID'],
                ]);

                if ($posts)
                    foreach($posts as $post) {
                        setup_postdata( $post );
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                        $imageAlt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(get_post_thumbnail_id()) ?: 'Tasyakur ID\'s image asset';
                        ?>

                        <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="100">
                            <div class="media-image">
                                <a href="<?the_permalink()?>"><img src="<?=$image[0]?>" alt="<?=$imageAlt?>" class="img-fluid"></a>
                                <div class="media-image-body">
                                    <h2 class="font-secondary text-uppercase"><a href="<?the_permalink()?>"><?=the_title()?></a></h2>
                                    <span class="d-block mb-3">By <?=get_the_author()?> &mdash; <?=get_the_date()?></span>
                                    <p><?the_excerpt()?></p>
                                    <p><a href="<?the_permalink()?>">Read More</a></p>
                                </div>
                            </div>
                        </div>

                        <?php
                    }

                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>


    <!-- Testimonials -->
    <div class="site-section block-14 nav-direction-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12">
                    <h2 class="site-section-heading text-center text-uppercase">Testimonials</h2>
                </div>
            </div>

            <div class="nonloop-block-14 owl-carousel">

                <?php
                $testimonials = get_posts([
                    'posts_per_page' => 10,
                    'orderby' => 'date',
                    'order' => 'ASC',
                    'post_type' => 'testimonials',
                    'fields' => ['ID'],
                ]);

                if ($testimonials)
                    foreach($testimonials as $post) {
                        setup_postdata( $post );
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                        $imageAlt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(get_post_thumbnail_id()) ?: 'Tasyakur ID\'s image asset';
                        ?>

                        <div class="d-block block-testimony mx-auto text-center">
                            <div class="person w-25 mx-auto mb-4">
                                <img src="<?=$image[0]?>" alt="<?=$imageAlt?>" class="img-fluid rounded-circle w-25 mx-auto">
                            </div>
                            <div>
                                <h2 class="h5 mb-4"><?=get_field('customer_name')?></h2>
                                <blockquote>&ldquo;<?=get_field('testimony')?>&rdquo;</blockquote>
                            </div>
                        </div>

                        <?php
                    }

                wp_reset_postdata();
                ?>

            </div>

        </div>

    </div>

    <!-- Custom Yours Now -->
    <div class="py-5 bg bg-color-primary">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 text-center mb-3 mb-md-0">
                    <h2 class="text-uppercase text-white mb-4" data-aos="fade-up">Custom Yours Now</h2>
                    <a href="<?=get_permalink( get_page_by_path('contact') )?>" class="btn btn-bg-primary font-secondary text-uppercase" data-aos="fade-up" data-aos-delay="100">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();
?>