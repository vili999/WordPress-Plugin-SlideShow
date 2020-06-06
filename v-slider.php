<?php

/*

Plugin Name: V-slider admin page
Description: Adds a custom admin pages for an image slider.
Version: 1.0.0
Author: Velyana Petrova
Text Domain: v-slider
*/

//function for register main admin page for plugin
function vili_register_slideshows_post_type() {
    register_post_type( 'slideshow', array(
        'labels' => array(
            'name' => 'Slideshows',
            'singular_name' => 'Slideshow',
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_admin_bar' => 'edit.php',
        'supports' => array( 'title' ,'thumbnail', 'editor' )
    ) );
}
add_action( 'init', 'vili_register_slideshows_post_type' );
  
//function limits number of posts to one
//This restriction is necessary, because there must be only one shortcode
function post_published_limit() {
    $max_posts = 1; // change this or set it as an option that you can retrieve.
    $author = $post->post_author; // Post author ID.

    $count = count_user_posts( $author, 'slideshow'); // get author post count

    if ( $count > $max_posts ) {
        $post = array('post_status' => 'draft');
        wp_update_post( $post );
    }
}
add_action( 'publish_slideshow', 'post_published_limit' );

// function that enqueue all scripts and styles
function anime_css_and_js_for_slider() {
	wp_enqueue_style( 'owlslider',  plugins_url ( '/owl.carousel/owl.carousel.css', __FILE__ ), '', null );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'owlsliderjs', plugins_url( '/owl.carousel/owl.carousel.min.js', __FILE__ ), array('jquery'), null, true );

    wp_register_script('v-sliderjs', plugins_url( '/v-slider.js', __FILE__ ) );
    wp_register_style('v-slidercss', plugins_url( '/v-slider.css', __FILE__ ) );
    wp_enqueue_script( 'v-sliderjs' );
    wp_enqueue_style( 'v-slidercss' );

}
 
add_action( 'wp_enqueue_scripts', 'anime_css_and_js_for_slider' );


//function that runs when shortcode is called
function slideshow_shortcode() { 
    add_image_size( 'my_slider', 640, 480, true ); // 640 - slider width, 480 - slider height
    // array with parameters
    $args = array(
        'post_parent' => $post->ID,
        'post_type' => 'attachment',
        'orderby' => 'menu_order', // you can also sort images by date or be name
        'order' => 'ASC',
        'numberposts' => 5, // number of images (slides)
        'post_mime_type' => 'image'
    );
    if ( $images = get_children( $args ) ) {
        // if there are no images in post, don't display anything
        echo '<ul id="slider" class="owl-carousel">';
        foreach( $images as $image ) {
            echo '<li>' . wp_get_attachment_image( $image->ID, 'my_slider' ) . '</li>';
        }
        echo '</ul>'; 
    }
} 
// register shortcode for the slideshow
add_shortcode('slideshow', 'slideshow_shortcode'); 

?>