<?php
get_header();
?>

<div class="pt-5 pb-3">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12" data-aos="fade">
                <h2 class="site-section-heading text-center text-uppercase"><?=the_title()?></h2>
            </div>
        </div>
        <div class="row">
            <?php
            $faqs = get_field('faqs');
            if ($faqs)
                foreach ($faqs as $faq) {
            ?>
                <div class="col-md-6 col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="d-flex align-items-center"><span class="circle-icon-wrap mr-3"><span class="icon-question"></span></span> <?=$faq['question']?></h3>
                    <p><?=$faq['answer']?></p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>
