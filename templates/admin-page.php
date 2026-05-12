<?php
/**
 * Template for Trades Share Intent Settings
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    
    <form method="post" action="options.php">
        <?php settings_fields( 'tradesw_share_intent_group' ); ?>

        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="tradesw_selected_posttype">
                            <?php esc_html_e( 'Target Post Types', 'tradesw-share-intent' ); ?>
                        </label>
                    </th>
                    <td>
                        <?php $this->render_post_select(); ?>
                        <br>
                        <?php $this->render_active_post_types(); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php submit_button( __( 'Save Intent Settings', 'tradesw-share-intent' ) ); ?>
    </form>
</div>