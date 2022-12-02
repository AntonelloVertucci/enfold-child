<?php

/*
    =============================================
    Backend Footer
    =============================================
*/
function AV_footer_admin_left_func(){
    $blog_public = 0 == get_option( 'blog_public' ) ? '<span style="color: red">OFF</span>' : '<span style="color: green">ON</span>';
    echo '<span style="font-size: 11px; color:black; letter-spacing: 2px;">NECKARMEDIA</span>
          <span style="font-size: 11px; color:red;">PHP ' . PHP_VERSION . '</span> |  
          <span style="font-size: 11px; color:blue;">WP ' . get_bloginfo( "version" ) .'</span> | 
          <span style="font-size: 11px; color:black;">SEO-Index:</span> <b>' . $blog_public . '</b>';
}
add_filter('admin_footer_text', 'AV_footer_admin_left_func');


/*
    =============================================
    ENFOLD
    =============================================
*/
/* Debug modus */
function AV_enfold_debug_modus_func(){
  return "debug";
}
add_action('avia_builder_mode', "AV_enfold_debug_modus_func");

/* Remove Avia Framework debug information */
if(!function_exists('avia_debugging_info')){
  	function avia_debugging_info(){}
}

/* Remove the Import Dummy Data button (Demo) */
add_theme_support('avia_disable_dummy_import');

/* Disable Portfolio 
function AV_disable_portfolio_func(){
    remove_action('init', 'portfolio_register');
}
add_action('after_setup_theme', 'AV_disable_portfolio_func');
*/

/* Replace portfolio name */
function AV_change_portfolio_name_func($args){
    $args['labels']['name'] = 'Produkte';
    return $args;
}
add_filter('avf_portfolio_cpt_args', 'AV_change_portfolio_name_func');

/* Hide editor info / Post state */
function AV_remove_ALB_post_state_func( $post_states, $post ){
    if("! has_blocks( $post->ID )") {
        unset($post_states['wp_editor']);
    }
    if("!= Avia_Builder()->get_alb_builder_status($post->ID)"){
        unset($post_states['avia_alb']);
    }
return $post_states;
}
add_filter('display_post_states','AV_remove_ALB_post_state_func', 999, 2);

/* Remove Enfold Image sizes */
function AV_remove_enfold_image_sizes_func(){
    //remove_image_size('widget');
	remove_image_size('square');
	remove_image_size('featured');
	remove_image_size('featured_large');
	remove_image_size('portfolio');
	remove_image_size('portfolio_small');
	remove_image_size('gallery');
	remove_image_size('magazine');
	remove_image_size('masonry');
	remove_image_size('entry_without_sidebar');
	remove_image_size('entry_with_sidebar');
	remove_image_size('shop_thumbnail');
	remove_image_size('shop_catalog');
	remove_image_size('shop_single'); 
  remove_image_size('shop_gallery_thumbnail');
}
add_action('init', 'AV_remove_enfold_image_sizes_func');


/*
    =============================================
    Hide Updates notification in WP Backend
    =============================================
*/
function AV_hide_update_notification_func(){
  echo '<style>
        .update-nag,
        .update-plugins{display: none !important}
        </style>';
}
add_action('admin_head', 'AV_hide_update_notification_func');


/*
    =============================================
    Login Logo
    =============================================
*/
function AV_custom_login_logo_func(){
    echo '<style type="text/css">
        h1 a { background-image:url('. get_stylesheet_directory_uri() .'/img/loginlogo.png) !important; 
        background-size:250px 100px !important;
        width:250px !important;
        height: 100px !important;
        }
    </style>';
}
add_action('login_head', 'AV_custom_login_logo_func');


/*
    =============================================
    Remove Wordpress Header Info
    =============================================
*/
function AV_remove_header_info_func(){ 
    remove_action('wp_head', 'feed_links_extra', 3); 
    remove_action('wp_head', 'rsd_link'); 
    remove_action('wp_head', 'wlwmanifest_link'); 
    remove_action('wp_head', 'wp_generator'); 
    remove_action('wp_head', 'start_post_rel_link'); 
    remove_action('wp_head', 'index_rel_link'); 
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); 
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head',10,0); 
} 
add_action('init', 'AV_remove_header_info_func');


/*
    =============================================
    Remove extra global-styles-inline-css and SVG Filters
    =============================================
*/
add_action( 'after_setup_theme', function(){
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
    remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
    remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
} );


/*
    =============================================
    Enqueue scripts
    =============================================
*/
function AV_enqueue_scripts_func(){    
    wp_register_script('script', get_stylesheet_directory_uri() . '/js/script.js','','', true);
    wp_enqueue_script('script');
}
add_action('wp_enqueue_scripts', 'AV_enqueue_scripts_func');
