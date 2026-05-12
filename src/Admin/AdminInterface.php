<?php
namespace Trades_Share_Intent\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Trades_Share_Intent\Core\Plugin;

/**
 * Handles the admin interface and AJAX requests.
 */
class AdminInterface {

    /**
     * The available posttypes.
     *
     * @var array
     */
    private $posttypes;

    /**
     * AdminInterface constructor.
     * @defaults post, attachment
     * @add 'wp_template_part' or 'page' or 'CPT'
     * @since 1.0
     * @return array
     */
    public function __construct() {
        $this->posttypes = array(
            'post', 'attachment'
        );
    }

    /**
     * Add the admin menu page.
     */
    public function add_menu_page() {
        add_management_page(
            esc_html__( 'Trades Share Intent', 'tradesw-share-intent' ),
            esc_html__( 'Trades ShareIntent', 'tradesw-share-intent' ),
            'manage_options',
            TSW_SHARE_INTENT_SLUG,
            array( $this, 'render_admin_page' )
        );
    }

    /**
     * Enqueue scripts and styles.
     *
     * @param string $hook The current admin page hook.
     */
    public function enqueue_assets( $hook ) {
        if ( 'tools_page_' . TSW_SHARE_INTENT_SLUG !== $hook ) {
            return;
        }

        // Enqueue CSS.
        wp_enqueue_style( TSW_SHARE_INTENT_SLUG . '-admin-css', 
            TSW_SHARE_INTENT_PLUGIN_URL . 'assets/css/admin.css', 
            array(), TSW_SHARE_INTENT_VERSION );

        // Enqueue JavaScript.
        //wp_enqueue_script( TPC_SLUG . '-admin-js', TPC_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), TPC_VERSION, true );

        // Pass data to the JavaScript file.
        /* wp_localize_script( TPC_SLUG . '-admin-js', 'tpc_ajax_object', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'tpc_admin_nonce' ),
            'posttypes' => $this->posttypes,
            'i18n'     => array(
                'categorySaved' => esc_html__( 'Category saved!', 'tsw-plugin-categorizer' ),
                'categoryRemoved' => esc_html__( 'Category removed!', 'tsw-plugin-categorizer' ),
            ),
        ) ); */
    }

    /**
     * Render the admin page template.
     */
    public function render_admin_page() {
        
        // Build the list of uncategorized plugins.
        /* foreach ( $all_plugins as $plugin_slug => $plugin_data ) {
            if ( ! isset( $categorized_plugins[ $plugin_slug ] ) ) {
                $uncategorized_plugins[ $plugin_slug ] = $plugin_data;
            }
        } */

        // Get suggested posttypes for uncategorized plugins.
       // $suggested_posttypes = Plugin::get_instance()->->get_suggested_posttypes( $uncategorized_plugins );

        // Include the template.
        include TSW_SHARE_INTENT_PLUGIN_DIR . 'templates/admin-page.php';
    }

    /**
     * Add a drop down select of post types.
     *
     * @param array $columns The columns array.
     * @return array The filtered columns array.
     */
    public function render_post_select( ) {
       // Get post types
        $args       = array(
            'public'   => true,
            '_builtin' => true,
        );
        $post_types = get_post_types( $args, 'objects' );
        ?>
        <select class="widefat" name="post_type">
            <?php foreach ( $post_types as $post_type_obj ):
                $labels = get_post_type_labels( $post_type_obj );
                ?>
                <option value="<?php echo esc_attr( $post_type_obj->name ); ?>">
                    <?php echo esc_html( $labels->name ); ?></option>
            <?php endforeach; ?>
        </select>
        <?php 
    }

    /**
     * Display content for the post types.
     */
    public function posttypes() {
        
        $args = array(
        'public'   => true,
        '_builtin' => true
        );
        
        $output = 'names'; // 'names' or 'objects' (default: 'names')
        $operator = 'and'; // 'and' or 'or' (default: 'and')
        
        $post_types = get_post_types( $args, $output, $operator );
        
        if ( $post_types ) { // If there are any custom public post types.
        
            echo '<ul>';
        
            foreach ( $post_types  as $post_type ) {
                echo '<li>' . $post_type . '</li>';
            }
        
            echo '</ul>';
        
        }
    }
    /**
     * AJAX handler to save a plugin's category.
     */
    
}