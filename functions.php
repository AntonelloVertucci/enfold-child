<?php


/*
    =============================================
    Backend Footer
    =============================================
*/
function nm_footer_admin_left(){
echo '<span style="font-size: 11px; color:black; letter-spacing: 2px;">NECKARMEDIA</span>
      <span style="font-size: 11px; color:red;">PHP '.PHP_VERSION.'</span> |  
      <span style="font-size: 11px; color:blue;">WP '.get_bloginfo( "version" ).'</span>';
}
add_filter('admin_footer_text', 'nm_footer_admin_left');


/*
    =============================================
    ENFOLD
    =============================================
*/
/* Debug modus */
function nm_enfold_debug_modus(){
  return "debug";
}
add_action('avia_builder_mode', "nm_enfold_debug_modus");

/* Remove Avia Framework debug information */
if(!function_exists('avia_debugging_info')){
  	function avia_debugging_info() {}
}

/* Remove the Import Dummy Data button (Demo) */
add_theme_support('avia_disable_dummy_import');

/* Backend Style */
function nm_custom_enfold_style(){
  echo '<style>
    #pr-logo{display:none}
    .avia_options_page_sidebar .avia_header{background-size:60px; background-position:center; background-image: url('. get_stylesheet_directory_uri() .'/img/n-logo.png); background-repeat:no-repeat}
    } 
  </style>';
}
add_action('admin_head', 'nm_custom_enfold_style');

/* Disable Portfolio 
function nm_remove_portfolio(){
    remove_action('init', 'portfolio_register');
}
add_action('after_setup_theme', 'nm_remove_portfolio');
*/

/* Replace portfolio name */
function nm_portfolio_name($args){
    $args['labels']['name'] = 'Produkte';
    return $args;
}
add_filter('avf_portfolio_cpt_args', 'nm_portfolio_name');

/* Remove time from the enfold latest news widget */
function nm_change_avia_date_format($date, $function){
    $output = get_option('date_format');
    return $output;
}
add_filter('avia_widget_time', 'nm_change_avia_date_format', 10, 2);

/* Hide editor info / Post state */
function nm_remove_ALB_post_state( $post_states, $post ){
    if("! has_blocks( $post->ID )") {
        unset($post_states['wp_editor']);
    }
    if("!= Avia_Builder()->get_alb_builder_status($post->ID)") {
        unset($post_states['avia_alb']);
    }
return $post_states;
}
add_filter('display_post_states','nm_remove_ALB_post_state',999,2);

/* Shortcode to display Breadcrumb [nm_breadcrumb] */
function nm_breadcrumb_func( $atts ){
    global $avia_config;
    return Avia_Breadcrumb_Trail()->get_trail($args);
}
add_shortcode( 'nm_breadcrumb', 'nm_breadcrumb_func' );

/* Disable Enfold Image generation 
function nm_ava_image_sizes(){ 
    remove_image_size('masonry');
    remove_image_size('magazine');
    remove_image_size('featured');
    remove_image_size('featured_large');
    remove_image_size('extra_large');
    remove_image_size('portfolio_small');
    remove_image_size('gallery');
    remove_image_size('entry_with_sidebar');
    remove_image_size('entry_without_sidebar');
    remove_image_size('square');
}
add_action( 'after_setup_theme', 'nm_ava_image_sizes', 11 );
*/


/*
    =============================================
    Hide Updates notification in WP Backend
    =============================================
*/
function nm_hide_update_notification() {
  echo '<style>
        .update-nag,
        .update-plugins{display: none !important}
        </style>';
}
add_action('admin_head', 'nm_hide_update_notification');


/*
    =============================================
    Call a navigation menu using a shortcode [menu name="MENUNAME"]
    =============================================
*/
function nm_menu_shortcode($atts, $content = null){
    extract(shortcode_atts(array( 'name' => null, ), $atts));
    return wp_nav_menu( array( 'menu' => $name, 'echo' => false ) );
}
add_shortcode('menu', 'nm_menu_shortcode');


/*
    =============================================
    Add Category in Body Class if is single
    =============================================
*/
function pn_body_class_add_categories( $classes ){
    if ( !is_single() ) return $classes;

    $post_categories = get_the_category();
    foreach( $post_categories as $current_category ) {
        $classes[] = 'cat-' . $current_category->slug;
    }
    return $classes;
}
add_filter( 'body_class', 'pn_body_class_add_categories' );


/*
    =============================================
    Login error
    =============================================
*/
function av_login_errors($error){
    $pos = strpos($error, 'incorrect');
    if (is_int($pos)){
        $error = "Error...";
    }
    return $error;
}
add_filter('login_errors', 'av_login_errors');


/*
    =============================================
    Login Logo
    =============================================
*/
function my_custom_login_logo(){
    echo '<style type="text/css">
        h1 a { background-image:url('. get_stylesheet_directory_uri() .'/img/loginlogo.png) !important; 
        background-size:250px 100px !important;
        width:250px !important;
        height: 100px !important;
        }
    </style>';
}
add_action('login_head', 'my_custom_login_logo');


/*
    =============================================
    Remove Dashboard Widget
    =============================================
*/
function remove_dashboard_meta(){
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
    remove_action('welcome_panel', 'wp_welcome_panel');
}
add_action( 'admin_init', 'remove_dashboard_meta' );


/*
    =============================================
    Remove Wordpress Header Info
    =============================================
*/
function sam_remove_header_info(){ 
    remove_action('wp_head', 'feed_links_extra', 3); 
    remove_action('wp_head', 'rsd_link'); 
    remove_action('wp_head', 'wlwmanifest_link'); 
    remove_action('wp_head', 'wp_generator'); 
    remove_action('wp_head', 'start_post_rel_link'); 
    remove_action('wp_head', 'index_rel_link'); 
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); 
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head',10,0); 
} 
add_action('init', 'sam_remove_header_info');


/*
    =============================================
    Enqueue Script.js
    =============================================

function script_js() {    
    $script = get_stylesheet_directory_uri() . '/js/script.js';
    wp_register_script('script', $script, array('jquery'),'', true);
    wp_enqueue_script('script');
}
add_action('wp_enqueue_scripts', 'script_js');
*/





