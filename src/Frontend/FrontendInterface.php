<?php
namespace Trades_Share_Intent\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class FrontendInterface {

    public function __construct() {
        // The singleton instantiation triggers this filter
        add_filter( 'the_content', array( $this, 'inject_share_intent' ) );
    }

    public function inject_share_intent( $content ) {
        // Retrieve the multi-select array (defaults to 'post')
        $enabled_types = get_option( 'tradesw_selected_posttype', array( 'post' ) );

        // Standard WordPress check for singular posts/pages of selected types
        if ( ! is_singular( $enabled_types ) || ! is_main_query() ) {
            return $content;
        }

        $url   = urlencode( get_permalink() );
        $title = urlencode( get_the_title() );

        // Building the HTML (Keeping your privacy-first/no-cookie stance)
        $share_html  = '<div class="tradesw-share-intent-wrap" style="margin-top:2em; border-top:1px solid #eee; padding-top:1em;">';
        $share_html .= '<h4>' . esc_html__( 'Share this post:', 'tradesw-share-intent' ) . '</h4>';
        $share_html .= '<div style="display:flex; gap:10px;">';
        
        $share_html .= $this->build_link( "https://twitter.com/intent/tweet?text={$title}&url={$url}", 'X' );
        $share_html .= $this->build_link( "https://www.facebook.com/sharer/sharer.php?u={$url}", 'Facebook' );
        $share_html .= $this->build_link( "https://www.linkedin.com/sharing/share-offsite/?url={$url}", 'LinkedIn' );
        
        $share_html .= '</div></div>';

        return $content . $share_html;
    }

    private function build_link( $href, $label ) {
        return sprintf(
            '<a href="%1$s" target="_blank" rel="noopener noreferrer" style="padding:5px 10px; border:1px solid #333; text-decoration:none; color:#333;">%2$s</a>',
            esc_url( $href ),
            esc_html( $label )
        );
    }
}