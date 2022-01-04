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

        }

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


}

// Instantiate the class
$oliemonster_portal = new OliemonsterPortal();

?>