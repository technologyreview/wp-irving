<?php
/**
 * Plugin Name:     WP Irving
 * Description:     Use WordPress as the API for Irving.
 * Author:          Alley
 * Author URI:      https://alley.co
 * Text Domain:     wp-irving
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         WP_Irving
 */

define( 'WP_IRVING_PATH', dirname( __FILE__ ) );
define( 'WP_IRVING_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_IRVING_VERSION', '1.0' );

// Flush rewrite rules when the plugin is activated or deactivated.
register_activation_hook( __FILE__, 'flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

// Base classes.
require_once WP_IRVING_PATH . '/inc/endpoints/class-endpoint.php';

// API.
require_once WP_IRVING_PATH . '/inc/endpoints/class-components-endpoint.php';
require_once WP_IRVING_PATH . '/inc/endpoints/class-data-endpoint.php';
require_once WP_IRVING_PATH . '/inc/endpoints/class-form-endpoint.php';

// Integrations.
require_once WP_IRVING_PATH . '/inc/integrations/class-wpcom-legacy-redirector.php';
require_once WP_IRVING_PATH . '/inc/integrations/class-safe-redirect-manager.php';
require_once WP_IRVING_PATH . '/inc/integrations/class-google-amp.php';
require_once WP_IRVING_PATH . '/inc/integrations/class-archiveless.php';

// Redirects.
require_once WP_IRVING_PATH . '/inc/redirects.php';

// Rewrite rules.
require_once WP_IRVING_PATH . '/inc/rewrites.php';

// Debugging helpers.
require_once WP_IRVING_PATH . '/inc/debug.php';
