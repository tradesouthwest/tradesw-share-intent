<?php
namespace Trades_Share_Intent\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FrontendInterface {

    public function __construct() {
        add_action( 'wp_head', array( $this->public_interface, 'add_meta_tags') );
        // 1. Logic Hook (The "When")
        //add_filter( 'the_content', array( $this, 'inject_share_intent' ) );
    }
    
    /**
    * Meta tags
    * fb shows only home page.
    * x posts twice but format OK.
    * @ OK.
    * Bs OK.
    * In OK.
    */
    public function add_meta_tags() {
        if (is_single()) {
            global $post;
            //$url   = esc_url(get_permalink($post->ID));
            $url = urlencode(get_permalink());
            $title = esc_attr(get_the_title($post->ID));
            
            // Essential OG tags for Facebook to identify the specific post
            echo '<meta property="og:url" content="' . $url . '" />' . "\n";
            echo '<meta property="og:type" content="article" />' . "\n";
            echo '<meta property="og:title" content="' . $title . '" />' . "\n";

            $img_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
            
            if ($img_data) {
                $img_url    = esc_url($img_data[0]);
                $img_width  = $img_data[1];
                $img_height = $img_data[2];
                
                echo '<meta property="og:image" content="' . $img_url . '" />' . "\n";
                echo '<meta property="og:image:width" content="' . $img_width . '" />' . "\n";
                echo '<meta property="og:image:height" content="' . $img_height . '" />' . "\n";
                
                echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
                echo '<meta name="twitter:image" content="' . $img_url . '" />' . "\n";
            }
        }
    }


    /**
     * Add styles to head
     */
    public function frontend_styles() {
        echo '<style id="tradesw-social-intent">
            .tradesw-share-box { display: flex; gap: 15px; margin: 20px 0; padding: 10px; border-top: 1px solid #eee; align-items: center;  }
            .tradesw-share-link { text-decoration: none; display: flex; align-items: center; transition: opacity 0.2s; }
            .tradesw-share-link:hover { opacity: 0.7; }
            .tradesw-share-link svg { width: 24px; height: 24px; fill: currentColor; }
            .icon-fb { color: #1877F2; } .icon-x { color: #000000; } .icon-li { color: #0A66C2; } .icon-th { color: #000000; } .icon-bs { color: #0085ff; }
        </style>';
    }
    
    /**
     * inject share intent
     */
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
        //$template_path = dirname( __DIR__, 2 ) . '../../templates/frontend-page.php';
        $template_path = TSW_SHARE_INTENT_PLUGIN_DIR . 'templates/frontend-page.php';
    // DEBUG: This will show you the exact path PHP is trying to use
    /*if ( current_user_can( 'manage_options' ) ) {
        echo 'permissions not granted';
    }*/

        if ( file_exists( $template_path ) ) {
            // Define the array that your template is looking for
            $share_data = array(
                'url'   => get_permalink(),
                'title' => get_the_title(),
            );
    
            // By defining $share_data here, it becomes available inside frontend-page.php
            include_once $template_path;
        } else {
            echo "no template found";
        }
    }
}