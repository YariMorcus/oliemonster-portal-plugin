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



    }

}

// Instantiate the class
$oliemonster_portal = new OliemonsterPortal();

?>