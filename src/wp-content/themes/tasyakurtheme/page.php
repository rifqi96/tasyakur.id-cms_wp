<?php
get_header();
?>

<div class="site-section py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12" data-aos="fade">
                <h2 class="site-section-heading text-center text-uppercase"><?=the_title()?></h2>
            </div>
        </div>
        <div class="row no-gutters align-items-stretch">
            <?php
            // TO SHOW THE PAGE CONTENTS
            while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
                <div class="col py-2">
                    <?php the_content(); ?> <!-- Page Content -->
                </div><!-- .entry-content-page -->

            <?php
            endwhile; //resetting the page loop
            wp_reset_query(); //resetting the page query
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>
