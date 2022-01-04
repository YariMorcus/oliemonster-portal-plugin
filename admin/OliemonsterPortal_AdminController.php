<?php 

/**
 * This Admin controller file provides the functionality for the Admin section of the
 * Oliemonster portal
 * 
 * @author Yari Morcus
 * @version 0.1
 * 
*/
class OliemonsterPortal_AdminController {

    /**
     * prepare
     * 
     * This function will prepare all Admin functionality for the plugin
    */
    static function prepare() {

        // Check if current user is an administrator
        if( is_admin() ) {

            // Add the sidebar menu structure
            add_action( 'admin_menu', array( 'OliemonsterPortal_AdminController', 'addMenus' ) );

        }
    }

    /**
     * addMenus
     * 
     * Add the sidebar menu structure
    */
    static function addMenus() {

        add_menu_page(
            // $page_title, The text to be displayed in the title tags of the page when the menu is selected
            __( 'Oliemonster portal Admin dashboard', 'oliemonster-portal' ),
            // $menu_title, The text to be used for the menu.
            __( 'Dashboard', 'oliemonster-portal' ),
            // $capability, The capability required for this menu to be displayed to the user
            'manage_options',
            // $menu_slug, The slug name to refer to this menu by. Should be unique for this menu page
            'oliemonster-portal-admin-dashboard',
            // $function, The function to be called to output the content for this page
            array( 'OliemonsterPortal_AdminController', 'adminDashboardPage' ),
            // $icon_url, The URL to the icon to be used for this menu.
            // Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme. This should begin with 'data:image/svg+xml;base64,'.
            // Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
            // Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
            'dashicons-dashboard'
        );

    }

    /**
     * adminDashboardPage
    */
    static function adminDashboardPage() {


        // Include the view for this menu page
        include OLIEMONSTER_PORTAL_PLUGIN_ADMIN_VIEWS_DIR . '/admin_dashboard.php';
    }

}

?>