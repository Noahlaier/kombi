<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Enqueue parent and child theme styles
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_enqueue_styles' );
function chld_thm_cfg_enqueue_styles() {
    // Parent style
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    // Child style (optional, only if you have a style.css in your child theme)
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ), wp_get_theme()->get('Version') );
}

