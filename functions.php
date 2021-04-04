<?php

function famita_child_enqueue_styles() {
	wp_enqueue_style( 'famita-child-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'famita_child_enqueue_styles', 100 );
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
function no_wordpress_errorss(){
  return 'you have already permanet block!';
}
add_filter( 'login_errors', 'no_wordpress_errorss' );
add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');
function translate_text($translated) {
$translated = str_ireplace('SELECT OPTIONS', 'ADD TO CART', $translated);
return $translated;
}
add_filter('gettext', 'translate_texts');
add_filter('ngettext', 'translate_texts');
function translate_texts($translated1) {
$translated1 = str_ireplace('READ MORE', 'ADD TO CART', $translated1);
return $translated1;
}
function my_login_custom_message(){
   // login message to show to users
   return "Alanic @ActiveWear Best WorkOut Cloth In Pakistan";
}
add_filter("login_message","my_login_custom_message");
function modify_logo() {
    $logo_style = '<style type="text/css">';
    $logo_style .= 'h1 a {background-image: url(' . get_template_directory_uri() . '/images/logo.png) !important;}';
    $logo_style .= '</style>';
    echo $logo_style;
}
add_action('login_head', 'modify_logo');  

function my_custom_login_error_msges($error){

   // code for custom error messages
   global $errors;
   //empty_password, invalid_username, incorrect_password, empty_username 
    $error_code = $errors->get_error_codes();
 $error_msg = '';
 if(in_array("empty_password",$error_code)){
     $error_msg = "You have no value in password field";
 }
 
 if(in_array("invalid_username",$error_code)){
     $error_msg = "Invalid username detected";
 }
 
 if(in_array("incorrect_password",$error_code)){
    $error_msg = "Incorrect passord found, please enter again";
 }
 
 return $error_msg;

}
add_filter("login_errors","my_custom_login_error_msges");
function remove_admin_logo() {
	echo '<style>img#header-logo { display: none; }</style>';
}
add_action('admin_head', 'remove_admin_logo');
//limit login attempt
function check_attempted_login( $user, $username, $password ) {
    if ( get_transient( 'attempted_login' ) ) {
        $datas = get_transient( 'attempted_login' );

        if ( $datas['tried'] >= 3 ) {
            $until = get_option( '_transient_timeout_' . 'attempted_login' );
            $time = time_to_go( $until );

            return new WP_Error( 'too_many_tried',  sprintf( __( '<strong>ERROR</strong>: You have reached authentication limit, you will be able to try again in %1$s.' ) , $time ) );
        }
    }

    return $user;
}
add_filter( 'authenticate', 'check_attempted_login', 30, 3 ); 
function login_failed( $username ) {
    if ( get_transient( 'attempted_login' ) ) {
        $datas = get_transient( 'attempted_login' );
        $datas['tried']++;

        if ( $datas['tried'] <= 3 )
            set_transient( 'attempted_login', $datas , 300 );
    } else {
        $datas = array(
            'tried'     => 1
        );
        set_transient( 'attempted_login', $datas , 300 );
    }
}
add_action( 'wp_login_failed', 'login_failed', 10, 1 ); 

function time_to_go($timestamp)
{
// converting the mysql timestamp to php time
    $periods = array(
        "second",
        "minute",
        "hour",
        "day",
        "week",
        "month",
        "year"
    );
    $lengths = array(
        "60",
        "60",
        "24",
        "7",
        "4.35",
        "12"
    );
    $current_timestamp = time();
    $difference = abs($current_timestamp - $timestamp);
    for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i ++) {
        $difference /= $lengths[$i];
    }
    $difference = round($difference);
    if (isset($difference)) {
        if ($difference != 1)
            $periods[$i] .= "s";
            $output = "$difference $periods[$i]";
            return $output;
    }
}
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'PKR': $currency_symbol = 'Pkr '; break;
     }
     return $currency_symbol;
}

remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');
function shapeSpace_remove_version_scripts_styles($src) {
	if (strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}
add_filter('style_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);

function det_up_no( $value ) {

    if ( isset( $value ) && is_object( $value ) ) {
        unset( $value->response[ 'js_composer/js_composer.php' ] );
    }

    return $value;
}
add_filter( 'site_transient_update_plugins', 'det_up_no' );
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 function custom_override_checkout_fields( $fields ) {
unset($fields['billing']['billing_company']);
unset($fields['billing']['billing_postcode']);
unset($fields['billing']['billing_last_name']);
$fields['billing']['billing_first_name']['label'] = 'Full Name';
return $fields;
}
function jeherve_remove_state_field( $fields ) {
	unset( $fields['state'] );
return $fields;
}
add_filter( 'woocommerce_default_address_fields', 'jeherve_remove_state_field' );
function exclude_woocommerce_styles() {
//remove generator meta tag
remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

//check woo exists
if ( function_exists( 'is_woocommerce' ) ) {
//dequeue scripts and styles
  if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
    wp_dequeue_style( 'woocommerce_frontend_styles' );
    wp_dequeue_style( 'woocommerce_fancybox_styles' );
    wp_dequeue_style( 'woocommerce_chosen_styles' );
    wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
    wp_dequeue_script( 'wc_price_slider' );
    wp_dequeue_script( 'wc-single-product' );
    wp_dequeue_script( 'wc-add-to-cart' );
    wp_dequeue_script( 'wc-cart-fragments' );
    wp_dequeue_script( 'wc-checkout' );
    wp_dequeue_script( 'wc-add-to-cart-variation' );
    wp_dequeue_script( 'wc-single-product' );
    wp_dequeue_script( 'wc-cart' );
    wp_dequeue_script( 'wc-chosen' );
    wp_dequeue_script( 'woocommerce' );
    wp_dequeue_script( 'prettyPhoto' );
    wp_dequeue_script( 'prettyPhoto-init' );
    wp_dequeue_script( 'jquery-blockui' );
    wp_dequeue_script( 'jquery-placeholder' );
    wp_dequeue_script( 'fancybox' );
    wp_dequeue_script( 'jqueryui' );
    }
  }
}
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0); 
remove_action('wp_head', 'parent_post_rel_link', 10, 0); 
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); 
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action ('template_redirect', 'wp_shortlink_header', 11, 0);
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action('wp_head', 'noindex', 1);
remove_action('welcome_panel', 'wp_welcome_panel');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
  remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
 add_filter('embed_oembed_discover', '__return_false');
remove_action( 'wp_head', 'wp_oembed_add_host_js');


add_action( 'wp_dashboard_setup', function()
{
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
} );
function cry_clean_header_hook(){
	wp_deregister_script( 'comment-reply' );
         }
add_action('init','cry_clean_header_hook');
function speed_stop_loading_wp_embed() {
    if (!is_admin()) {
        wp_deregister_script('wp-embed');
    }
}
add_action('init', 'speed_stop_loading_wp_embed');
// Disable Self Pingback
function disable_pingback( &$links ) {
  foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}

add_action( 'pre_ping', 'disable_pingback' );
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    
}
add_action( 'init', 'disable_emojis' );
add_action( 'init', 'stop_heartbeat', 1 );
    function stop_heartbeat() {
    wp_deregister_script('heartbeat');
}
add_filter( 'auto_update_theme', '__return_true' );
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
//block malicious request
global $user_ID; if($user_ID) {
    if(!current_user_can('administrator')) {
        if (strlen($_SERVER['REQUEST_URI']) > 255 ||
            stripos($_SERVER['REQUEST_URI'], "eval(") ||
            stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
            stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
            stripos($_SERVER['REQUEST_URI'], "base64")) {
                @header("HTTP/1.1 414 Request-URI Too Long");
                @header("Status: 414 Request-URI Too Long");
                @header("Connection: Close");
                @exit;
        }
    }
}

function block_spam_comments($commentdata) {
	$fake_textarea = trim($_POST['comment']);
	if(!empty($fake_textarea)) wp_die('Error!');
	$comment_content = trim($_POST['just_another_id']);
	$_POST['comment'] = $comment_content;	
	return $commentdata;
}
 
add_filter('pre_comment_on_post', 'block_spam_comments');
add_action('wp_head', 'myoverride', 1);
function myoverride() {
  if ( class_exists( 'Vc_Manager' ) ) {
    remove_action('wp_head', array(visual_composer(), 'addMetaData'));
  }
}
add_filter( 'revslider_meta_generator', '__return_empty_string');
// Disable Dashicons in Front-end
function wpdocs_dequeue_dashicon() {
	if (current_user_can( 'update_core' )) {
	    return;
	}
	wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );
// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');
function defer_parsing_of_js( $url ) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );
function defer_parsing_of_js( $url ) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return str_replace( ' src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
function defer_parsing_of_javascript ( $url ) {
  if ( FALSE === strpos( $url, '.js' ) ) return $url;
  if ( strpos( $url, 'jquery.js' ) ) return $url;
    return "$url' defer ";
}
add_filter( 'clean_url', 'defer_parsing_of_javascript', 11, 1 );