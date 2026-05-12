<?php
/**
 * Template for the Frontend Share Intent buttons.
 * Available variable: $share_data
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$url   = urlencode( $share_data['url'] );
$title = urlencode( $share_data['title'] );

// Define the platforms in a loop for easier maintenance
$platforms = array(
    'x' => array(
        'label' => 'X (Twitter)',
        'url'   => "https://twitter.com/intent/tweet?text={$title}&url={$url}",
    ),
    'facebook' => array(
        'label' => 'Facebook',
        'url'   => "https://www.facebook.com/sharer/sharer.php?u={$url}",
    ),
    'linkedin' => array(
        'label' => 'LinkedIn',
        'url'   => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
    ),
);
?>

<div class="tradesw-share-intent-wrap">
    <h4><?php esc_html_e( 'Share this:', 'tradesw-share-intent' ); ?></h4>
    <ul class="tradesw-share-links">
        <?php foreach ( $platforms as $key => $platform ) : ?>
            <li class="share-<?php echo esc_attr( $key ); ?>">
                <a href="<?php echo esc_url( $platform['url'] ); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="tsw-share-btn">
                    <?php echo esc_html( $platform['label'] ); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>