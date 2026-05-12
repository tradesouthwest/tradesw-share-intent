<?php
namespace Trades_Share_Intent\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FrontendInterface {

    public function __construct() {
        // 1. Logic Hook (The "When")
        //add_filter( 'the_content', array( $this, 'inject_share_intent' ) );
    }

    public function inject_share_intent( $content ) {
        $enabled_types = get_option( 'tradesw_selected_posttype', array( 'post' ) );

        // If we aren't on the right post type, return content immediately and EXIT.
        if ( ! is_singular( $enabled_types ) || ! is_main_query() || ! in_the_loop() ) {
            return $content;
        }

        // Capture the template
        ob_start();
        $this->render_frontend_page();
        $share_html = ob_get_clean();

        // Return content + the captured template
        return $content . $share_html;
        }

    /**
     * render_frontend_page
     */
    public function render_frontend_page() {
        $template_path = TSW_SHARE_INTENT_PLUGIN_DIR . 'templates/frontend-page.php';
        if ( file_exists( $template_path ) ) {
            include $template_path;
        }
    }
}