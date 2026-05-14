<?php
namespace Tradesw_Share_Intent\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FrontendInterface {

    /**
     * Constructor.
     * * Initialized hooks for metadata injection into the site head.
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'wp_head', array( $this, 'add_meta_tags') );
    }

    /**
     * Adds Open Graph and Twitter metadata tags to the document head.
     * * Specifically targets single post views to ensure social platforms 
     * scrape the correct title, URL, and featured image.
     * * @since 1.0.0
     * @return void
     */
    public function add_meta_tags() {
        if (is_single()) {
            global $post;

            $url     = rawurlencode( get_permalink( $post->ID ) );
            $title   = esc_html( get_the_title( $post->ID ) );
            $img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            // Essential OG tags for Facebook to identify the specific post
            echo '<meta name="generator" content="TradeswShareIntent v1.0" />' . "\n";
            echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
            echo '<meta property="og:type" content="article" />' . "\n";
            // ToDo Add description tag. Use Excerpt maybe.
            echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
            echo '<meta property="og:image" content="' . esc_url( $img_url ) . '" />' . "\n";
            echo '<meta name="twitter:title" content="' . esc_html( $title ) . '" />' . "\n";
            echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
            echo '<meta name="twitter:image" content="' . esc_url( $img_url ) . '" />' . "\n";
        }
    }

    /**
     * Outputs internal CSS styles for the share intent interface.
     * * Hooks into the head to provide layout and coloring for social icons.
     * * @since 1.0.0
     * @return void
     */
    public function frontend_styles() {
        echo '<style id="tradesw-social-intent">
            .tradesw-share-intent-wrap { display: flex; gap: 15px; margin: 20px 0; padding: 10px; border-top: 1px solid #eee; align-items: center;  }
            .tradesw-share-links { list-style: none; text-decoration: none; display: flex; align-items: center; transition: opacity 0.2s; }
            .tradesw-share-links li { margin-left: .5rem; } .tradesw-share-links:hover { opacity: 0.7; }
            .tradesw-share-links svg { width: 24px; height: 24px; fill: currentColor; }
            .icon-fb { color: #1877F2; } .icon-x { color: #000000; } .icon-li { color: #0A66C2; } .icon-th { color: #000000; } .icon-bs { color: #0085ff; }
        </style>';
    }
    
    /**
     * Injects the share intent HTML into the post content.
     * * Filters the content to append the rendered share buttons on allowed post types.
     * * @since 1.0.0
     * @param string $content The original post content.
     * @return string The modified content with share intent HTML appended.
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
     * Renders the social share template file.
     * * Locates the template file, prepares the data array, and includes the file
     * to be captured by the output buffer.
     * * @since 1.0.0
     * @return void
     */
    public function render_frontend_page() {
        // Path to template.
        $template_path = TSW_SHARE_INTENT_PLUGIN_DIR . 'templates/frontend-page.php';
    // DEBUG: This will show you the exact path PHP is trying to use

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