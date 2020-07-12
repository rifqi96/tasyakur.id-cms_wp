<?php
get_header();
if (have_posts())
    while (have_posts()) {
        the_post();
?>
<div class="site-section pt-5">
    <?get_template_part('template-parts/product', 'details')?>
    <?get_template_part('template-parts/product', 'related-products')?>
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
}
get_footer();
?>
