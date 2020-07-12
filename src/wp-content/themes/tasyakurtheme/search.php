<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 */

get_header();
$postType = get_post_type() ?: get_query_var('post_type')[0] ?? 'post';
?>

    <div class="site-section pt-5" data-aos="fade">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12" data-aos="fade">
                    <h2 class="site-section-heading text-center text-uppercase">Search results for <span class="font-italic"><?=$s?></span> in <?=$postType?> section</h2>
                </div>
            </div>
            <div class="row mb-5">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
                        $imageAlt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(get_post_thumbnail_id()) ?: 'Tasyakur ID\'s image asset';
                        ?>
                        <div class="col-md-6 col-lg-4 mb-5">
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
                }
                ?>
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <?php
                    pagination();
                    ?>
                </div>
            </div>
        </div>
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