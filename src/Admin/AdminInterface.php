<?php
namespace Trades_Share_Intent\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AdminInterface {

    public function __construct() {
        // Hooks for the Settings API
        add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );
    }

    /**
     * Register the setting in the options table.
     */
    public function register_plugin_settings() {
        register_setting( 
            'tradesw_share_intent_group', 
            'tradesw_selected_posttype', 
            array(
                'type'              => 'array',
                'sanitize_callback' => array( $this, 'sanitize_post_types' ),
                'default'           => array( 'post' ),
            )
        );
    }

    /**
     * Ensure we only save an array of strings.
     */
    public function sanitize_post_types( $input ) {
        return is_array( $input ) ? array_map( 'sanitize_text_field', $input ) : array( 'post' );
    }

    /**
     * Add the admin menu page.
     */
    public function add_menu_page() {
        add_management_page(
            esc_html__( 'Trades Share Intent', 'tradesw-share-intent' ),
            esc_html__( 'Trades Share Intent', 'tradesw-share-intent' ),
            'manage_options',
            TSW_SHARE_INTENT_SLUG,
            array( $this, 'render_admin_page' )
        );
    }

    /**
     * Dropdown for the admin page.
     */
    public function render_post_select() {
        // Get all public post types (Posts, Pages, and CPTs)
        $post_types = get_post_types( array( 'public' => true ), 'objects' );
        
        // Retrieve the saved array. Default to 'post' if empty.
        $selected_values = get_option( 'tradesw_selected_posttype', array( 'post' ) );
        
        // Ensure it's an array for in_array() checks
        if ( ! is_array( $selected_values ) ) {
            $selected_values = array( $selected_values );
        }

        ?>
        <select class="widefat" name="tradesw_selected_posttype[]" id="tradesw_selected_posttype" multiple style="height: 120px;">
            <?php foreach ( $post_types as $post_type_obj ) : ?>
                <option value="<?php echo esc_attr( $post_type_obj->name ); ?>" 
                    <?php echo in_array( $post_type_obj->name, $selected_values ) ? 'selected' : ''; ?>>
                    <?php echo esc_html( $post_type_obj->labels->name ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">
            <?php esc_html_e( 'Cmd/Ctrl + Click to select multiple types.', 'tradesw-share-intent' ); ?>
        </p>
        <?php
    }

    /**
     * Display the Active Selection
     * Shows the user what is currently saved in the database.
     */
    public function render_active_post_types() {
        $selected_values = get_option( 'tradesw_selected_posttype', array( 'post' ) );
        
        if ( empty( $selected_values ) ) {
            echo '<em>' . esc_html__( 'No post types selected.', 'tradesw-share-intent' ) . '</em>';
            return;
        }

        echo '<div style="margin-top: 10px; padding: 10px; background: #fff; border: 1px solid #ccd0d4; display: inline-block;">';
        echo '<strong>' . esc_html__( 'Active on:', 'tradesw-share-intent' ) . '</strong> ';
        
        $names = array();
        foreach ( (array) $selected_values as $type ) {
            $obj = get_post_type_object( $type );
            $names[] = $obj ? $obj->labels->singular_name : $type;
        }
        
        echo esc_html( implode( ', ', $names ) );
        echo '</div>';
    }

    /**
     * Render the admin page template using your constant.
     */
    public function render_admin_page() {
        // Using your corrected constant name
        $template_path = TSW_SHARE_INTENT_PLUGIN_DIR . 'templates/admin-page.php';
        
        if ( file_exists( $template_path ) ) {
            include_once $template_path;
        } else {
            echo '<div class="error"><p>Template not found at: ' . esc_html( $template_path ) . '</p></div>';
        }
    }
} 