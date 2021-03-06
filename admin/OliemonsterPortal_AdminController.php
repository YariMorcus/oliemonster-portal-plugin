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
     * 
    */
    static function prepare() {

            // Add the sidebar menu structure
            add_action( 'admin_menu', array( 'OliemonsterPortal_AdminController', 'addMenus' ) );
        
    }

    /**
     * addMenus
     * 
     * Add the sidebar menu structure
     * 
    */
    static function addMenus() {

        // Add menu page for admin only
        add_menu_page(
            // $page_title, The text to be displayed in the title tags of the page when the menu is selected
            __( 'Oliemonster portal admin dashboard', 'oliemonster-portal' ),
            // $menu_title, The text to be used for the menu.
            __( 'Portal dashboard', 'oliemonster-portal' ),
            // $capability, The capability required for this menu to be displayed to the user
            'oliepor_admin_view_dashboard',
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

        add_menu_page(
            // $page_title, The text to be displayed in the title tags of the page when the menu is selected
            __( 'Oliemonster portal dashboard', 'oliemonster-portal' ),
            // $menu_title, The text to be used for the menu.
            __( 'Portal dashboard', 'oliemonster-portal' ),
            // $capability, The capability required for this menu to be displayed to the user
            'oliepor_subscriber_view_dashboard',
            // $menu_slug, The slug name to refer to this menu by. Should be unique for this menu page
            'oliemonster-portal-dashboard',
            // $function, The function to be called to output the content for this page
            array( 'OliemonsterPortal_AdminController', 'subscriberDashboardPage' ),
            // $icon_url, The URL to the icon to be used for this menu.
            // Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme. This should begin with 'data:image/svg+xml;base64,'.
            // Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
            // Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
            'dashicons-dashboard'            
        );

        add_submenu_page(
            // $parent_slug, The slug name for the parent menu (or the file name of a standard WordPress admin page)
            // Null indicates that it is an admin page, but should NOT be showed as a menu item
            // This page is ONLY accessible from the dashboard
            null,
            // $page_title, The text to be displayed in the title tags of the page when the menu is selected
            __( 'Oliemonster portal aanvragen controle', 'oliemonster-portal' ),
            // $menu_title, The text to be used for the menu.
            __( 'Aanvragen controle', 'oliemonster-portal' ),
            // $capability, The capability required for this menu to be displayed to the user
            'oliepor_subscriber_view_dashboard',
            // $menu_slug, The slug name to refer to this menu by. Should be unique for this menu page
            'aanvragen_controle',
            // $function, The function to be called to output the content for this page
            array( 'OliemonsterPortal_AdminController', 'subscriberRequestCheckPage' )            
        );

        add_submenu_page(
            // $parent_slug, The slug name for the parent menu (or the file name of a standard WordPress admin page)
            // Null indicates that it is an admin page, but should NOT be showed as a menu item
            // This page is ONLY accessible from the dashboard
            null,
            // $page_title, The text to be displayed in the title tags of the page when the menu is selected
            __( 'Bekijken gegevens controle' ),
            // $menu_title, The text to be used for the menu.
            null,
            // $capability, The capability required for this menu to be displayed to the user
            'oliepor_admin_view_dashboard',
            // $menu_slug, The slug name to refer to this menu by. Should be unique for this menu page
            'bekijken_gegevens',
            // $function, The function to be called to output the content for this page
            array( 'OliemonsterPortal_AdminController', 'viewDataRequestCheckPage' )

        );
        
    }

    /**
     * adminDashboardPage
     * 
     * Include the view for this menu page
     * 
    */
    static function adminDashboardPage() {

        include OLIEMONSTER_PORTAL_PLUGIN_ADMIN_VIEWS_DIR . '/admin_dashboard.php';
        
    }

    /**
     * subscriberDashboardPage
     * 
     * Include the view for this menu page
     * 
    */
    static function subscriberDashboardPage() {

        include OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_VIEWS_DIR . '/dashboard.php';

    }

    /**
     * subscriberRequestCheckPage
     * 
     * Include the view for this menu page
     * 
    */
    static function subscriberRequestCheckPage() {

        include OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_VIEWS_DIR . '/aanvragen_controle.php';

    }

    /**
     * viewDataRequestCheckPage
     * 
     * Include the view for this menu page
     * 
    */
    static function viewDataRequestCheckPage() {

        include OLIEMONSTER_PORTAL_PLUGIN_ADMIN_VIEWS_DIR . '/admin_inzien_gegevens.php';

    }

}

?>