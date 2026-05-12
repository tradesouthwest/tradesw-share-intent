<?php
namespace Trades_Share_Intent\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FrontendInterface {

    public function __construct() {
        // 1. Logic Hook (The "When")
        add_filter( 'the_content', array( $this, 'inject_share_intent' ) );
    }

    public function inject_share_intent( $content ) {
        $enabled_types = get_option( 'tradesw_selected_posttype', array( 'post' ) );

        if ( ! is_singular( $enabled_types ) || ! is_main_query() ) {
            return $content;
        }

        // TEST: If you see "BUFFER TEST" but no links, the template path is wrong.
        ob_start();
        echo '<strong>BUFFER TEST</strong>'; 
        $this->render_frontend_page();
        $share_html = ob_get_clean();

        return $content . $share_html;
        }

    /**
     * render_frontend_page
     */
    public function render_frontend_page() {
        $template_path = TSW_SHARE_INTENT_PLUGIN_DIR . 'templates/frontend-page.php';
        if ( file_exists( $template_path ) ) {
            // Explicitly define variables so the template can see them
            $post_url   = get_permalink();
            $post_title = get_the_title();
            
            include $template_path;
        } else {
            // Debugging: If you see this in your page source, the path is wrong
            echo 'oops';
        }
    }
}