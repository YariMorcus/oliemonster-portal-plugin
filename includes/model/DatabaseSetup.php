<?php 
/**
 * DatabaseSetup
 * 
 * @author Yari Morcus <ymorcus@student.scalda.nl>
 * @package Oliemonster portal plugin
 * @subpackage CreateDatabaseTables
 * @since 0.1
*/
class DatabaseSetup { 

    /**
     * createDBTables
     * 
     * Create the database tables for this plugin
     * 
    */
    public static function createDBTables() {

        // Load the DatabaseSetupQueries model
        require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/DatabaseSetupQueries.php';

        // Retrieve the SQL query for table creations
        $sql = DatabaseSetupQueries::setupTableQueries();

        // Include dbDelta
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        // Execute the query (create the tables)
        dbDelta( $sql );

    }
    /**
     * insertDBData
     * 
     * Insert the standard data for this plugin into the tables
     * 
    */
    public static function insertDBData() {

        // Include the IVS_Databases class
        require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/DatabaseSetupQueries.php';
        
        // Retrieve the table names
        $table_names = DatabaseSetupQueries::retrieveTables();

        // Insert data into the 'wp_oliepor_status_aanvragen' table
        DatabaseSetup::insertStatusAanvragenData($table_names);
        
    }

    /**
     * insertStatusAanvragenData
     * 
     * Insert data concerning the 'wp_oliepor_status' table
     * @param array, array holding the table names
     * 
    */
    private static function insertStatusAanvragenData( $table_names ) {

        // Define $wpdb as a global variable
        global $wpdb;

        // Insert first row in table 'wp_oliepor_status'
        $wpdb->insert(
            $table_names[1],
            array(
                'id' => 1,
                'status' => 'Sample nog niet ontvangen'
            )
        );

        // Insert second row in table 'wp_oliepor_status'
        $wpdb->insert(
            $table_names[1],
            array(
                'id' => 2,
                'status' => 'In behandeling'
            )
        );

        // Insert third row in table 'wp_oliepor_status'
        $wpdb->insert(
            $table_names[1],
            array(
                'id' => 3,
                'status' => 'Afgehandeld'
            )
        );

    }

}

?>