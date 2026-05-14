![Plugin banner](assets/banner-1544x500.png)

# Trades Share Intent
Adds social share buttons to bottom of posts with selectable post types.

- Requires PHP: 7.4
- Requires CP:  1.4
- Version:      1.0
- Author:       Tradesouthwest
- Tags:         share, social, intent
- License:      GPL 3 (see LICENSE)
- Text domain:  tradesw-visit-counter
- Plugin URL:   https://github.com/tradesouthwest/tradesw-share-intent

## Overview
This plugin is hard coded with most modern used metadata. We do this to save messy admin data storage of options.

## Features

1. Performance (SEO): Native intents don't require external scripts to load from Facebook or X. This keeps your "Daily Brief" pages lightweight, which directly helps maintain that GSC performance and mobile-first indexing speed.

2. Privacy/Compliance: Since you aren't loading tracking pixels from social giants, you’re providing a "cleaner" experience for your more privacy-conscious intelligence readers.

3. Bypassing the "Burnout": You've essentially "future-proofed" the site. No more fighting with broken third-party plugins every time an API updates—you own the logic now.

### The following meta tags will be added to your themes head:

```
<meta property="og:url" content="http://https%3A%2F%2Ftradesnet.us%2Fnew-test-post%2F" />
<meta property="og:url" content="Gets url of post" />
<meta property="og:type" content="article" />
<meta property="og:title" content="New test post" />
<meta property="og:image" content="gets url of featured image" />
<meta name="twitter:title" content="New test post" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image" content="https://tradesnet.us/wp-content/uploads/2026/05/Russian-ICBM-Sarmat.webp" />

```
### Upgrade Notice

If you find your theme has (duplicate) metadata tags in the head, be sure to comment out the ones you do not need in the file `src/Frontend/FrontendInterface.php` around line 35.

And if your theme does not support svgs (which is rare now days):

```
function tradesw_share_intent_add_mime_types($mimes) {
 $mimes['svg'] = 'image/svg+xml';
 return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
```
https://blog.cogitactive.com/website/enabling-wordpress-svg-safely/ 