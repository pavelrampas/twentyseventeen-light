<?php

function my_wp_enqueue_scripts() {
    wp_enqueue_style( 'twentyseventeen-light', get_theme_file_uri( '/style.css' ) );

	// dequeue styles
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'twentyseventeen-fonts' );
	wp_dequeue_style( 'twentyseventeen-style' );
	wp_dequeue_style( 'twentyseventeen-block-style' );
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_dequeue_style( 'twentyseventeen-colors-dark' );
	}
	if ( is_customize_preview() ) {
		wp_dequeue_style( 'twentyseventeen-ie9' );
	}
	wp_dequeue_style( 'twentyseventeen-ie8' );

	// dequeue scripts
	wp_dequeue_script( 'html5' );
	wp_dequeue_script( 'twentyseventeen-skip-link-focus-fix' );
	if ( has_nav_menu( 'top' ) ) {
		wp_dequeue_script( 'twentyseventeen-navigation' );
	}
	wp_dequeue_script( 'twentyseventeen-global' );
	wp_dequeue_script( 'jquery-scrollto' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_dequeue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'my_wp_enqueue_scripts', 11 );

/**
 * Disable embeds.
 */
function disable_embeds_code_init() {
	if ( ! is_admin() ) {
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
	}
}
add_action( 'init', 'disable_embeds_code_init', 11 );

/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 11, 2 );
}
add_action( 'init', 'disable_emojis' );
