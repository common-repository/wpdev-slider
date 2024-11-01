<?php
if( ! function_exists( 'wpdev_slider_get_placeholder_image' )){
    function wpdev_slider_get_placeholder_image(){
        return "<img src='" . wpdev_SLIDER_URL . "assets/images/default.jpg' class='img-fluid wp-post-image' />";
    }
}

if( ! function_exists( 'wpdev_slider_options' )){
    function wpdev_slider_options(){
        $show_bullets = isset( wpdev_Slider_Settings::$options['wpdev_slider_bullets'] ) && wpdev_Slider_Settings::$options['wpdev_slider_bullets'] == 1 ? true : false;

        wp_enqueue_script( 'wpdev-slider-options-js', wpdev_SLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), wpdev_SLIDER_VERSION, true );
        wp_localize_script( 'wpdev-slider-options-js', 'SLIDER_OPTIONS', array(
            'controlNav' => $show_bullets
        ) );
    }
}
