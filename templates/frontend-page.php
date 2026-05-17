<?php
/**
 * Template for the Frontend Share Intent buttons.
 * Available variable: $share_data
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$url      = rawurlencode( $share_data['url'] );
$titles   = rawurlencode( $share_data['title'] );
$tsi_text = esc_html__( 'Socialize:', 'tradesw-share-intent' ); // can be an option

// Define the platforms in a loop for easier maintenance
$platforms = array(
    'x' => array(
        'label' => '<svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'url'   => "https://twitter.com/intent/tweet?text={$titles}&url={$url}",
    ),
    'facebook' => array(
        'label' => 'FB',
        'url'   => "https://www.facebook.com/sharer/sharer.php?u={$url}",
    ),
    'linkedin' => array(
        'label' => '<svg viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>',
        'url'   => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
    ),
    'threads' => array(
        'label' => '<svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256"><title>Threads-logo SVG Icon</title><path fill="currentColor" d="M186.42 123.65a64 64 0 0 0-11.13-6.72c-4-29.89-24-39.31-33.1-42.07c-19.78-6-42.51 1.19-52.85 16.7a8 8 0 0 0 13.32 8.88c6.37-9.56 22-14.16 34.89-10.27c9.95 3 16.82 10.3 20.15 21a81 81 0 0 0-15.29-1.43c-13.92 0-26.95 3.59-36.67 10.1C94.3 127.57 88 139 88 152c0 20.58 15.86 35.52 37.71 35.52a48 48 0 0 0 34.35-14.81c6.44-6.7 14-18.36 15.61-37.1c.38.26.74.53 1.1.8C186.88 144.05 192 154.68 192 168c0 19.36-20.34 48-64 48c-26.73 0-45.48-8.65-57.34-26.44C60.93 175 56 154.26 56 128s4.93-47 14.66-61.56C82.52 48.65 101.27 40 128 40c32.93 0 54 13.25 64.53 40.52a8 8 0 1 0 14.93-5.75C194.68 41.56 167.2 24 128 24c-32 0-55.81 11.29-70.66 33.56C45.83 74.83 40 98.52 40 128s5.83 53.17 17.34 70.44C72.19 220.71 96 232 128 232c30.07 0 48.9-11.48 59.4-21.1C200.3 199.08 208 183 208 168c0-18.34-7.46-33.68-21.58-44.35m-37.89 38a31.94 31.94 0 0 1-22.82 9.9c-10.81 0-21.71-6-21.71-19.52c0-12.63 12-26.21 38.41-26.21a64 64 0 0 1 17.59 2.42c0 14.08-4 25.62-11.47 33.38Z"/></svg>',
        'url'   => "https://www.threads.net/intent/post?text='.$titles.'%20'.$url.'",
    ),
    'bluesky' => array(
        'label' => '<svg xmlns="http://www.w3.org/2000/svg" width="576" height="512" viewBox="0 0 576 512"><title>Bluesky SVG Icon</title><path fill="#1185fe" d="M439.8 358.7c-3.3-.4-6.7-.8-10-1.3c3.4.4 6.7.9 10 1.3M320 291.1c-26.1-50.7-97.1-145.2-163.1-191.8c-63.3-44.7-87.4-37-103.3-29.8C35.3 77.8 32 105.9 32 122.4S41.1 258 47 277.9c19.5 65.7 89.1 87.9 153.2 80.7c3.3-.5 6.6-.9 10-1.4c-3.3.5-6.6 1-10 1.4c-93.9 14-177.3 48.2-67.9 169.9C252.6 653.1 297.1 501.8 320 425.1c22.9 76.7 49.2 222.5 185.6 103.4c102.4-103.4 28.1-156-65.8-169.9c-3.3-.4-6.7-.8-10-1.3c3.4.4 6.7.9 10 1.3c64.1 7.1 133.6-15.1 153.2-80.7c5.9-19.9 15-138.9 15-155.5s-3.3-44.7-21.6-52.9c-15.8-7.1-40-14.9-103.2 29.8c-66.1 46.6-137.1 141.1-163.2 191.8"/></svg>',
        'url'   => "https://bsky.app/intent/compose?text='.$titles.'%20'.$url.'",
    )
);
?>

<div class="tradesw-share-intent-wrap">
    <h4><?php printf( esc_html__( '%s', 'tradesw-share-intent' ),     // phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
                !empty( $tsi_text ) ? esc_html($tsi_text) : esc_attr__( 'Share', 'tradesw-share-intent' ) 
                ); ?></h4>
    <ul class="tradesw-share-links">
        <?php foreach ( $platforms as $key => $platform ) : ?>
            <li class="share-<?php echo esc_attr( $key ); ?>">
                <a href="<?php echo esc_url( $platform['url'] ); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="tsw-share-btn">
                    <?php echo tradesw_get_safe_svg( $platform['label'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
