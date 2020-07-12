<div class="container">
    <div class="row mb-5">
        <div class="col-md-12" data-aos="fade">
            <h2 class="site-section-heading text-uppercase">Related Posts</h2>
        </div>
    </div>
    <div class="row">
        <?php
        global $post;
        $categories = wp_get_post_categories($post->ID);

        $posts = get_posts([
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'ASC',
            'post_type' => 'post',
            'fields' => ['ID'],
            'category__in' => $categories,
            'post__not_in' => [ $post->ID ],
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