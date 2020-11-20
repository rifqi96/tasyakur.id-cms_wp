<?php
$images = get_field('product_images');
$featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
$featuredImageAlt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title(get_post_thumbnail_id()) ?: 'Tasyakur ID\'s image asset';
$productDescription = get_field('product_description');
$price = get_field('product_price');
$contactOptions = get_option('contact');
$termLinks = get_the_term_list(get_the_ID(), 'products_category', ' ', ' / ');
?>
<div class="container">
    <div class="row mb-5">
        <div class="col-md-12 text-center" data-aos="fade">
            <span class="caption d-block mb-2 font-secondary font-weight-bold"><?=$termLinks?></span>
            <h2 class="site-section-heading text-uppercase text-center font-secondary"><?=the_title()?></h2>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-5 mb-4">
            <a href="<?=$featuredImage[0]?>" data-fancybox="gallery">
                <img src="<?=$featuredImage[0]?>" alt="<?=$featuredImageAlt?>" class="featured-img img-fluid">
            </a>
        </div>
        <div class="col-md-7">
            <div class="product-description mb-2">
                <?=$productDescription?>
            </div>
            <p class="d-inline p-2 bg-primary text-white">
                <span class="currency"><?=$price?></span>
            </p>
            <p class="whatsapp-us d-inline p-2">
                <a href="https://api.whatsapp.com/send?phone=<?=$contactOptions['wa_no']?>?>" class="btn btn-primary font-secondary text-uppercase text-white" target="_blank" class="p-2">
                    <span class="font-secondary icon-whatsapp"></span> Inquire Us
                </a>
            </p>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($images as $image) {
            ?>
            <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                <a href="<?=$image['url']?>" data-fancybox="gallery">
                    <img src="<?=$image['url']?>" alt="<?=$image['alt']?>" class="img-fluid">
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</div>