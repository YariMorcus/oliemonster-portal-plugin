<?php 
/**
 * Definitions needed in the plugin
 * 
 * @author Yari Morcus
 * @version 0.1
 * 
 * Version history
 * 0.1 Initial version
*/

// Version numbers has to be the same as in oliemonster-portal.php
define( 'OLIEMONSTER_PORTAL_PLUGIN_VERSION', '0.1' );

// Minimum required WordPress version for this plugin
define( 'OLIEMONSTER_PORTAL_PLUGIN_REQUIRED_WP_VERSION', '5.8.2' );

define( 'OLIEMONSTER_PORTAL_PLUGIN_BASENAME', plugin_basename( OLIEMONSTER_PORTAL_PLUGIN ) );

define( 'OLIEMONSTER_PORTAL_PLUGIN_NAME', trim( dirname( OLIEMONSTER_PORTAL_PLUGIN_BASENAME ), '/' ) );

// Folder structure enlisted below
define( 'OLIEMONSTER_PORTAL_PLUGIN_DIR', untrailingslashit( dirname( OLIEMONSTER_PORTAL_PLUGIN ) ) );

define( 'OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_DIR', OLIEMONSTER_PORTAL_PLUGIN_DIR . '/includes' );

define( 'OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR', OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_DIR . '/model' );

define( 'OLIEMONSTER_PORTAL_PLUGIN_ADMIN_DIR', OLIEMONSTER_PORTAL_PLUGIN_DIR . '/admin' );

define( 'OLIEMONSTER_PORTAL_PLUGIN_ADMIN_ASSETS_IMG_DIR', OLIEMONSTER_PORTAL_PLUGIN_ADMIN_DIR . '/assets/img' );

define( 'OLIEMONSTER_PORTAL_PLUGIN_ADMIN_ASSETS_CSS_DIR', OLIEMONSTER_PORTAL_PLUGIN_ADMIN_DIR . '/assets/css' );

define( 'OLIEMONSTER_PORTAL_PLUGIN_ADMIN_VIEWS_DIR', OLIEMONSTER_PORTAL_PLUGIN_ADMIN_DIR . '/views' );

?>