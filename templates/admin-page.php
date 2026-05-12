<div class="wrap">
    <h1><?php esc_html_e( 'Tradesw Share Intent Management', 'tradesw-share-intent' ); ?></h1>
    <p><?php esc_html_e( 'Select your post types and management.', 'tradesw-share-intent' ); ?></p>

    <div id="tpc-message" class="notice notice-success" style="display: none;">
        <p><?php esc_html_e( 'Success',  'tradesw-share-intent' ); ?></p>
    </div>

    <div class="tpc-container">
        <!-- Section for Uncategorized Plugins -->
        <div class="tpc-uncategorized-section">
            <h2><?php esc_html_e( 'Using Post Types', 'tradesw-share-intent' ); ?></h2>
            <div class="tpc-plugin-list">
                post type list
            </div>
        </div>

        <!-- Section for Categorized Plugins -->
        <div class="tpc-categorized-section">
            <h2><?php esc_html_e( 'Available Post Types', 'tradesw-share-intent' ); ?></h2>
            <div class="tpc-categorized-list">
                <?php $admin = new \Trades_Share_Intent\Admin\AdminInterface();
                    $admin->render_post_select();
                ?>
            </div>
        </div>
    </div>
</div>
