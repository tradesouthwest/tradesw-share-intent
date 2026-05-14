<?php
namespace Tradesw_Share_Intent\Core;

use Tradesw_Share_Intent\Admin\AdminInterface;
use Tradesw_Share_Intent\Frontend\FrontendInterface;
//use Tradesw_Share_Intent\Utils\PluginUtils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main plugin controller class.
 */
class Plugin {

    /**
     * Singleton instance.
     *
     * @var Plugin
     */
    private static $instance = null;

    /**
     * The utilities manager.
     *
     * @var UtilsManager
     */
    //public $utils_manager;

    /**
     * The admin interface handler.
     *
     * @var AdminInterface
     */
    public $admin_interface;

    /**
     * The plugin analyzer.
     *
     * @var PublicInterface
     */
    public $public_interface;

    /**
     * Get the singleton instance of the plugin.
     *
     * @return Plugin
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Plugin constructor.
     */
    private function __construct() {
        // Initialize core components.
        //$this->utils_manager     = new UtilsManager();
        $this->public_interface = new \Tradesw_Share_Intent\Frontend\FrontendInterface();
        $this->admin_interface  = new \Tradesw_Share_Intent\Admin\AdminInterface();

        // Register hooks.
        $this->register_hooks();
    }

    /**
     * Register WordPress hooks.
     */
    private function register_hooks() {
        // Hook for adding the admin menu page.
        add_action( 'admin_menu', array( $this->admin_interface, 'add_menu_page' ) );
        //add_action( 'admin_init', array( $this->admin_interface, 'register_plugin_settings' ) );
        add_action( 'wp_head', array( $this->public_interface, 'frontend_styles') );

        add_filter( 'the_content', array( $this->public_interface, 'inject_share_intent' ) );
    }

    /**
     * Plugin activation hook.
     * This is a static method as required by WordPress hook system.
     */
    public static function activate() {
        //$manager = new UtilsManager();
        //$manager->create_table();
    }

    /**
     * Plugin deactivation hook.
     * This is a static method as required by WordPress hook system.
     */
    public static function deactivate() {
        // No action needed on deactivation for this version.
        // We will not drop the table to preserve user data.
    }
} 