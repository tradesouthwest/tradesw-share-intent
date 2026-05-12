<?php
/**
 * Plugin Name:       Tradesw Share Intent
 * Plugin URI:        https://github.com/tradesouthwest/tradesw-share-intent
 * Description:       Adds social share buttons to bottom of posts
 * Version:           1.0.1
 * Requires at least: 4.9.15
 * Requires PHP:      7.4
 * Requires CP:       1.3
 * Author:            Larry Judd @Tradesouthwest
 * Author URI:        https://tradesouthwest.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tradesw-share-intent
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Define plugin constants.
define( 'TSW_SHARE_INTENT_VERSION', '1.0.0' );
// This gets the absolute path to the main plugin directory.
define( 'TSW_SHARE_INTENT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TSW_SHARE_INTENT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TSW_SHARE_INTENT_SLUG', 'tradesw-share-intent' );

/**
 * Autoload classes using the namespace and file structure.
 * This function is automatically called by PHP when a class is not found.
 */
spl_autoload_register( 'trades_share_intent_autoloader' );

function trades_share_intent_autoloader( $class ) {
    // Check if the class is within our defined namespace.
    if ( strpos( $class, 'Trades_Share_Intent\\' ) === 0 ) {
        // Remove the namespace prefix from the class name.
        $relative_class = str_replace( 'Trades_Share_Intent\\', '', $class );

        // Convert the namespace structure to a file path.
        // For example, TPC\Core\Plugin becomes Core/Plugin.
        $file = TSW_SHARE_INTENT_PLUGIN_DIR . 'src/' . str_replace( '\\', '/', $relative_class ) . '.php';

        // Check if the file exists before including it.
        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
}

/**
 * Main plugin function to retrieve the singleton instance.
 * We use a function instead of a direct class call to make it more accessible.
 * @return \\Core\Plugin
 */
function Trades_Share_Intent() {
    return \Trades_Share_Intent\Core\Plugin::get_instance();
}

// Initialize the plugin. This is where the singleton is first created.
Trades_Share_Intent();

/**
 * Register activation and deactivation hooks.
 * The static methods are defined in the main Plugin class.
 */
register_activation_hook( __FILE__, array( 'Trades_Share_Intent\Core\Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Trades_Share_Intent\Core\Plugin', 'deactivate' ) ); 