<?php
namespace Trades_Share_Intent\Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Suggests posttypes based on plugin data.
 */
class UtilsManager {

    /**
     * Get suggested posttypes for a list of plugins.
     *
     * @param array $plugins An array of plugin data.
     * @return array An associative array of plugin slugs and suggested categories.
     */
 /*   public function get_suggested_posttypes( $plugins ) {
        $suggestions = array();
        foreach ( $plugins as $plugin_slug => $plugin_data ) {
            $suggestion = $this->analyze_single_plugin( $plugin_data );
            if ( $suggestion ) {
                $suggestions[ $plugin_slug ] = $suggestion;
            }
        }
        return $suggestions;
    }
*/ 
}