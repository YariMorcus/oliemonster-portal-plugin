<?php 
/**
 * Plugin Name: Oliemonster portal
 * Description: This plugin adds the oliemonster portal as a functionality to WordPress.
 * Version: 0.1
 * Requires at least: 5.8.2
 * Requires PHP: 7.0.33
 * Author: Yari Morcus
 * Text Domain: oliemonster-portal
 * Domain Path: languages
 *  
 * This is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details
 * You should have received a copy of the GNU General Public License
 * along with your plugin. If not, see <http://www.gnu.org/licenses/>.
*/

// Define the plugin name
define( 'OLIEMONSTER_PORTAL_PLUGIN', __FILE__ );

// Include the general definition file
require_once plugin_dir_path( __FILE__ ) . 'includes/defs.php';

// Tell WordPress what to do when plugin has been activated
register_activation_hook( __FILE__, array( 'OliemonsterPortal', 'on_activation' ) );

/**
 * Class instantiates the entire plugin functionality
 * @author Yari Morcus
 * @version 0.1
 * 
 * 
*/
class OliemonsterPortal {

    /**
     * __construct
     * 
     * Run function as soon as plugin is being activated throughout WP admin
    */
    public function __construct() {

        // Fire a hook before the class is setup
        do_action( 'oliemonster_portal_pre_init' );

        // Load the plugin
        add_action( 'init', array( $this, 'init' ), 1 );

    }

    /**
     * init
     * 
     * Load the plugin into WordPress
     * 
     * @since 0.1
    */
    public function init() {

        // Run hook once plugin has been initialized
        do_action( 'oliemonster_portal_init' );

        // Load admin only components
        if ( is_admin() ) {
            
            // Load all admin specific includes
            $this->requireAdmin();

            // Setup admin page
            $this->createAdmin();

            // Load Bootstrap CSS/script files
            add_action( 'admin_enqueue_scripts', array( 'OliemonsterPortal', 'loadBootstrapFiles') );

            // Load Custom CSS
            $this->loadCustomCSS();

            // Add admin specific capability for plugin
            $this->addCustomAdminCapability();

            // Add subscriber specific capability for plugin
            $this->addCustomSubscriberCapability();

        }

    }

    /**
     * on_activation
     * 
     * if { ! current_user_can( 'activate_plugins' ) }, if user cannot activate plugin's, abort function 
     * (prevent user from activating plugin)
    */
    public static function on_activation() {

        if ( ! current_user_can( 'activate_plugins' ) ) return;

        require_once( OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/DatabaseSetup.php' );

        // Insert the tables
        DatabaseSetup::createDBTables();

        // Insert DB data
        DatabaseSetup::insertDBData();

    }

    /**
     * requireAdmin
     * 
     * Loads all admin related files into scope
    */
    public function requireAdmin() {

        // Admin controller file
        require_once OLIEMONSTER_PORTAL_PLUGIN_ADMIN_DIR . '/OliemonsterPortal_AdminController.php';

    }

    /**
     * createAdmin
     * 
     * Setup admin page
    */
    public function createAdmin() {

        OliemonsterPortal_AdminController::prepare();

    }

    /**
     * loadBootstrapCSS
     * 
     * Load the Bootstrap CSS
    */
    static function loadBootstrapFiles() {

        wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', false, null );
        
        wp_enqueue_script( 'bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', false, array(), false, true );

    }

    /**
     * loadCustomCSS
     *
     *  Load the custom CSS that has been used for this plugin
    */
    public function loadCustomCSS() {

        wp_enqueue_style( 'oliemonster-portal', plugin_dir_url(__FILE__) . 'admin/assets/css/style.css', array(), false, 'all' );

    }

    /**
     * addCustomAdminCapability
     * 
     * Add a custom administrator capability
    */
    public function addCustomAdminCapability() {

        // Get the administrator role
        $administrator_role = get_role( 'administrator' );

        // Add new capability
        $administrator_role->add_cap( 'oliepor_admin_view_dashboard' );

    }

    /**
     * addCustomSubscriberCapability
     * 
     * Add a custom subscriber capability
    */
    public function addCustomSubscriberCapability() {

        // Get the subscriber role
        $subscriber_role = get_role( 'subscriber' );

        // Add new capability
        $subscriber_role->add_cap( 'oliepor_subscriber_view_dashboard' );

    }


}

// Instantiate the class
$oliemonster_portal = new OliemonsterPortal();

?>