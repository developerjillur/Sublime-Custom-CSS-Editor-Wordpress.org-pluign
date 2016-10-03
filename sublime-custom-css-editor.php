<?php 
/**
 * Plugin Name: Sublime Custom CSS Editor
 * Plugin URI: http://a1lrsrealtyservices.com/wpdemo/
 * Description: Sublime Text Custom Wordpress Css Editor. You can easily write your custom css by using this plugin.
 * Author: Jillur Rahman, AsianCoders
 * Author URI: http://asiancoders.com
 * Version: 1.0
 * License: GPL2
 * Text Domain: sublimecsse
 */

defined('ABSPATH') or die("Restricted access!");

/**
 * Text domain
 */
function sublimecsse_textdomain() {
	load_plugin_textdomain( 'sublimecsse', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'sublimecsse_textdomain' );

/**
 * Settings link
 */
function sublimecsse_settings_link( $links ) {
	$settings_page = '<a href="' . admin_url( 'themes.php?page=sublime-custom-css-editor.php' ) .'">' . __( 'Settings', 'sublimecsse' ) . '</a>';
	array_unshift( $links, $settings_page );
	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'sublimecsse_settings_link' );


/**
 * Register Appearance" Admin Menu
 */
function sublimecsse_register_submenu_page() {
	add_theme_page( __( 'Sublime Custom CSS Editor', 'sublimecsse' ), __( 'Sublime Custom CSS', 'sublimecsse' ), 'edit_theme_options', basename( __FILE__ ), 'sublimecsse_render_submenu_page' );
}
add_action( 'admin_menu', 'sublimecsse_register_submenu_page' );

//  inc/sublimecsse_function.php'; 
require_once( plugin_dir_path( __FILE__ ) . 'inc/sublimecsse_function.php' );

function sublimecsse_register_settings() {
	register_setting( 'sublimecsse_settings_group', 'sublimecsse_settings' );
}
add_action( 'admin_init', 'sublimecsse_register_settings' );

// admin_enqueue_scripts
function sublimecsse_enqueue_editor_scripts($hook) {

    // Return if the page is not a settings page of this plugin
    if ( 'appearance_page_sublime-custom-css-editor' != $hook ) {
        return;
    }

    // Style sheet
    wp_enqueue_style('codemirror-css', plugin_dir_url(__FILE__) . 'inc/css/codemirror.css');
    wp_enqueue_style('foldgutter-css', plugin_dir_url(__FILE__) . 'inc/css/addon/foldgutter.css');
    wp_enqueue_style('dialog-css', plugin_dir_url(__FILE__) . 'inc/css/addon/dialog.css');
    wp_enqueue_style('show-hint-css', plugin_dir_url(__FILE__) . 'inc/css/addon/show-hint.css');
    wp_enqueue_style('monokai_theme', plugin_dir_url(__FILE__) . 'inc/css/theme/monokai.css');
    wp_enqueue_style('sublimecsse-css', plugin_dir_url(__FILE__) . 'inc/css/sublimecsse.css');

    // js
    wp_enqueue_script('codemirror-js', plugin_dir_url(__FILE__) . 'inc/js/codemirror.js');
    wp_enqueue_script('css-js', plugin_dir_url(__FILE__) . 'inc/js/css.js');

    wp_enqueue_script('searchcursor-js', plugin_dir_url(__FILE__) . 'inc/js/addon/searchcursor.js');
    wp_enqueue_script('search-js', plugin_dir_url(__FILE__) . 'inc/js/addon/search.js');
    wp_enqueue_script('dialog-js', plugin_dir_url(__FILE__) . 'inc/js/addon/dialog.js');
    wp_enqueue_script('matchbrackets-js', plugin_dir_url(__FILE__) . 'inc/js/addon/matchbrackets.js');
    wp_enqueue_script('closebrackets-js', plugin_dir_url(__FILE__) . 'inc/js/addon/closebrackets.js');
    wp_enqueue_script('comment-js', plugin_dir_url(__FILE__) . 'inc/js/addon/comment.js');
    wp_enqueue_script('hardwrap-js', plugin_dir_url(__FILE__) . 'inc/js/addon/hardwrap.js');
    wp_enqueue_script('foldcode-js', plugin_dir_url(__FILE__) . 'inc/js/addon/foldcode.js');
    wp_enqueue_script('brace-fold-js', plugin_dir_url(__FILE__) . 'inc/js/addon/brace-fold.js');
    wp_enqueue_script('active-line-js', plugin_dir_url(__FILE__) . 'inc/js/addon/active-line.js');
    wp_enqueue_script('show-hint-js', plugin_dir_url(__FILE__) . 'inc/js/addon/show-hint.js');
    wp_enqueue_script('css-hint-js', plugin_dir_url(__FILE__) . 'inc/js/addon/css-hint.js');
    wp_enqueue_script('sublime-js', plugin_dir_url(__FILE__) . 'inc/js/sublime.js');

}
add_action( 'admin_enqueue_scripts', 'sublimecsse_enqueue_editor_scripts' );


/**
 * Include CSS in header
 */
function sublimecsse_add_styling_head() {
    // Read variables from BD
    $options = get_option( 'sublimecsse_settings' );
    $content = esc_textarea( $options['sublimecsse-content'] );
    
    // Cleaning
    $content = trim( $content );
    
    // Styling
    if (!empty($content)) {
        echo '<style rel="stylesheet" type="text/css">' . "\n";
        echo $content . "\n";
        echo '</style>' . "\n";
    }
}
add_action( 'wp_head', 'sublimecsse_add_styling_head' );

/**
 * Delete options on uninstall
 */
function sublimecsse_uninstall() {
    delete_option( 'sublimecsse_settings' );
}
register_uninstall_hook( __FILE__, 'sublimecsse_uninstall' );