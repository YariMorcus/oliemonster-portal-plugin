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

            // Add the sidebar menu structure
            add_action( 'admin_menu', array( 'OliemonsterPortal_AdminController', 'addMenus' ) );

        
    }

    /**
     * addMenus
     * 
     * Add the sidebar menu structure
    */
    static function addMenus() {

        // Add menu page for admin only
        add_menu_page(
            // $page_title, The text to be displayed in the title tags of the page when the menu is selected
            __( 'Oliemonster portal dashboard', 'oliemonster-portal' ),
            // $menu_title, The text to be used for the menu.
            __( 'Portal dashboard', 'oliemonster-portal' ),
            // $capability, The capability required for this menu to be displayed to the user
            'read',
            // $menu_slug, The slug name to refer to this menu by. Should be unique for this menu page
            'oliemonster-portal-dashboard',
            // $function, The function to be called to output the content for this page
            array( 'OliemonsterPortal_AdminController', 'dashboardPage' ),
            // $icon_url, The URL to the icon to be used for this menu.
            // Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme. This should begin with 'data:image/svg+xml;base64,'.
            // Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
            // Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
            'dashicons-dashboard'
        );

        // Add menu page for subscribers only
        // add_menu_page(
        //     // $page_title, The text to be displayed in the title tags of the page when the menu is selected
        //     __( 'Oliemonster portal dashboard', 'oliemonster-portal' ),
        //     // $menu_title, The text to be used for the menu.
        //     __( 'Portal dashboard', 'oliemonster-portal' ),
        //     // $capability, The capability required for this menu to be displayed to the user
        //     'read',
        //     // $menu_slug, The slug name to refer to this menu by. Should be unique for this menu page
        //     'oliemonster-portal-dashboard',
        //     // $function, The function to be called to output the content for this page
        //     array( 'OliemonsterPortal_AdminController', 'subscriberDashboardPage' ),
        //     // $icon_url, The URL to the icon to be used for this menu.
        //     // Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme. This should begin with 'data:image/svg+xml;base64,'.
        //     // Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
        //     // Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
        //     'dashicons-dashboard'
        // );

        
    }

    /**
     * dashboardPage
    */
    static function dashboardPage() {


        // Include the view for this menu page
        include OLIEMONSTER_PORTAL_PLUGIN_ADMIN_VIEWS_DIR . '/dashboard.php';
    }

    /**
     * subscriberDashboardPage
    */
    // static function subscriberDashboardPage() {

    //     // Include the view for this menu page
    //     include OLIEMONSTER_PORTAL_PLUGIN_ADMIN_VIEWS_DIR . '/subscriber_dashboard.php';
    // }

}

?>