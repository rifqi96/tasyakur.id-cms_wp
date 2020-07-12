<?php
get_header();
?>
    <div class="site-section py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12" data-aos="fade">
                    <h2 class="site-section-heading text-center text-uppercase">Whoops! The page you are looking for is not available.</h2>
                </div>
            </div>
            <div class="d-flex justify-content-center py-2">
                <div class="col-md-12 sidebar">
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