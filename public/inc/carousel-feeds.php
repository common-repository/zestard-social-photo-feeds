<?php

//Option values
$spf_show_navigation_arrow = sanitize_text_field(get_option('spf_show_navigation_arrow'));
$spf_enable_autoplay = sanitize_text_field(get_option('spf_enable_autoplay'));
$spf_interval_time = sanitize_text_field(get_option('spf_interval_time'));
$spf_no_of_photos = sanitize_text_field(get_option('spf_no_of_photos'));
$spf_no_of_column = sanitize_text_field(get_option('spf_no_of_column'));

//Navigation arrow value
if ($spf_show_navigation_arrow == 'true') {

    $spf_show_nav = sanitize_text_field('true');
    $spf_navtext_prev = "<div class='spf-nav-btn spf-prev-slide'></div>";
    $spf_navtext_next = "<div class='spf-nav-btn spf-next-slide'></div>";

} else {

    $spf_show_nav = sanitize_text_field('false');
}

//Autoplay value
if ($spf_enable_autoplay == 'true') {
    $spf_enable_auto = sanitize_text_field('true');
} else {
    $spf_enable_auto = sanitize_text_field('false');
}

//Set interval time value
if ($spf_interval_time) {
    $spf_int_time = $spf_interval_time;
} else {
    $spf_int_time = sanitize_text_field('5000');
}

//Set number of columns display
if ($spf_no_of_column) {
    $spf_slide_column = $spf_no_of_column;
} else {
    $spf_slide_column = sanitize_text_field('4');
}

?>

<!-- Call owl carousel js -->

<script type="text/javascript">

    jQuery(document).ready(function (jQuery) {

        jQuery('#spf-feed-carousel.owl-carousel').owlCarousel({
            margin: 10,
            items: <?php echo esc_html__($spf_slide_column, SPF_TEXT_DOMAIN); ?>,
            nav: <?php echo esc_html__($spf_show_nav, SPF_TEXT_DOMAIN); ?>,
            navText: ["<?php echo $spf_navtext_prev; ?>", "<?php echo $spf_navtext_next; ?>"],
            dots: false,
            loop: true,
            autoplay: <?php echo esc_html__($spf_enable_auto, SPF_TEXT_DOMAIN); ?>,
            autoplayTimeout: <?php echo esc_html__($spf_int_time, SPF_TEXT_DOMAIN); ?>,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2
                },
                767: {
                    items: 3
                },
                1080: {
                    items: <?php echo esc_html($spf_slide_column); ?>
                }
            }
        });

    });

</script>