<?php
get_header();
$featuredImg = wp_get_attachment_image_src(get_post_thumbnail_id());
?>
<div class="site-blocks-cover inner-page overlay" style="background-image: url(<?=$featuredImg[0]?>);" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="row align-items-center justify-content-center">
        <div class="col-md-12 text-center" data-aos="fade">
            <h1 class="text-uppercase"><?=the_title()?></h1>
            <? global $post ?>
            <span class="caption d-block text-white"><?=get_the_date()?> &bullet; Posted By <?the_author_meta('user_nicename', $post->post_author)?></span>
        </div>
    </div>
</div>

<div class="pt-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col blog-content">
                <?php
                if (have_posts())
                    while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/content', 'blog');
                    }
                ?>

                <?php
                // comments_template();
                ?>
            </div>
        </div>
    </div>

    <?php
    get_template_part('template-parts/content', 'related-posts');
    ?>
</div>

<div class="pb-5">
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-12" data-aos="fade">
                <h4 class="site-section-sm text-uppercase">Need to find more ? Key in your keywords below</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="sidebar-box">
                    <? get_template_part('template-parts/component', 'searchform'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
