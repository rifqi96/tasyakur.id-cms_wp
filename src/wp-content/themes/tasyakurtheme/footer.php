<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 */

?>

        <footer class="site-footer bg-dark">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-8">
                        <p>
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> Tasyakur.ID
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <?php
                                    $contactOptions = get_option('contact');
                                    ?>
                                    <a href="https://instagram.com/<?=$contactOptions['instagram']?>" target="_blank" class="p-2"><span class="icon-instagram"></span></a>
                                    <a href="<?=$contactOptions['facebook']?>" target="_blank" class="pb-2 pr-2 pl-0"><span class="icon-facebook"></span></a>
                                    <a href="https://api.whatsapp.com/send?phone=<?=$contactOptions['wa_no']?>&text=<?=esc_html($contactOptions['wa_message'])?>" target="_blank" class="p-2"><span class="icon-whatsapp"></span></a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </footer>
    </div>
</div>

<script src="<?=get_theme_file_uri()?>/js/jquery-3.3.1.min.js"></script>
<script src="<?=get_theme_file_uri()?>/js/jquery-migrate-3.0.1.min.js"></script>
<script src="<?=get_theme_file_uri()?>/js/jquery-ui.js"></script>
<script src="<?=get_theme_file_uri()?>/js/popper.min.js"></script>
<script src="<?=get_theme_file_uri()?>/js/bootstrap.min.js"></script>
<script src="<?=get_theme_file_uri()?>/js/owl.carousel.min.js"></script>
<script src="<?=get_theme_file_uri()?>/js/jquery.stellar.min.js"></script>

<script src="<?=get_theme_file_uri()?>/js/jquery.waypoints.min.js"></script>
<script src="<?=get_theme_file_uri()?>/js/jquery.animateNumber.min.js"></script>
<script src="<?=get_theme_file_uri()?>/js/aos.js"></script>
<script src="<?=get_theme_file_uri()?>/js/jquery.fancybox.min.js"></script>

<script src="<?=get_theme_file_uri()?>/js/main.js"></script>

<?php wp_footer(); ?>

</body>
</html>
