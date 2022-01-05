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
    */
    public static function createDBTables() {

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
    */
    public static function insertDBData() {

        // Include the IVS_Databases class
        require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/DatabaseSetupQueries.php';
        
        // Retrieve the table names
        $table_names = DatabaseSetupQueries::retrieveTables();
        
        // Insert data into the 'wp_oliepor_filters_ververst' table
        DatabaseSetup::insertFiltersVerverstData($table_names);

        // Insert data into the 'wp_oliepor_filters_ververst' table
        DatabaseSetup::insertKoelmiddelgebruiktData($table_names);

        // Insert data into the 'wp_oliepor_olie_ververst' table
        DatabaseSetup::insertOlieVerverstData($table_names);

        // Insert data into the 'wp_oliepor_status_aanvragen' table
        DatabaseSetup::insertStatusAanvragenData($table_names);
        
    }

    /**
     * insertFiltersVerverstData
     * 
     * Insert data concerning the 'wp_oliepor_filters_ververst' table
    */
    private static function insertFiltersVerverstData($table_names) {

        global $wpdb;

        // Insert first row in table 'wp_oliepor_filters_ververst'
        $wpdb->insert(
            $table_names[1],
            array(
                'ID' => 1,
                'antwoord' => 'Ja'
            )
        );

        // Insert second row in table 'wp_oliepor_filters_ververst'
        $wpdb->insert(
            $table_names[1],
            array(
                'ID' => 2,
                'antwoord' => 'Nee'
            )
        );

    }

    /**
     * insertKoelmiddelgebruiktData
     * 
     * Insert data concerning the 'wp_oliepor_koelmiddel_gebruikt' table
    */
    private static function insertKoelmiddelgebruiktData($table_names) {

        global $wpdb;

        // Insert first row in table 'wp_oliepor_koelmiddel_gebruikt'
        $wpdb->insert(
            $table_names[2],
            array(
                'ID' => 1,
                'antwoord' => 'Ja'
            )
        );

        // Insert second row in table 'wp_oliepor_koelmiddel_gebruikt'
        $wpdb->insert(
            $table_names[2],
            array(
                'ID' => 2,
                'antwoord' => 'Nee'
            )
        );

    }

    /**
     * insertOlieVerverstData
     * 
     * Insert data concerning the 'wp_oliepor_olie_ververst' table
    */
    private static function insertOlieVerverstData($table_names) {

        global $wpdb;

        // Insert first row in table 'wp_oliepor_olie_ververst'
        $wpdb->insert(
            $table_names[3],
            array(
                'ID' => 1,
                'antwoord' => 'Ja'
            )
        );

        // Insert second row in table 'wp_oliepor_olie_ververst'
        $wpdb->insert(
            $table_names[3],
            array(
                'ID' => 2,
                'antwoord' => 'Nee'
            )
        );

    }

    /**
     * insertStatusAanvragenData
     * 
     * Insert data concerning the 'wp_oliepor_status_aanvragen' table
    */
    private static function insertStatusAanvragenData($table_names) {

        global $wpdb;

        // Insert first row in table 'wp_oliepor_status_aanvragen'
        $wpdb->insert(
            $table_names[4],
            array(
                'ID' => 1,
                'status' => 'Sample nog niet ontvangen'
            )
        );

        // Insert second row in table 'wp_oliepor_status_aanvragen'
        $wpdb->insert(
            $table_names[4],
            array(
                'ID' => 2,
                'status' => 'In behandeling'
            )
        );

        // Insert third row in table 'wp_oliepor_status_aanvragen'
        $wpdb->insert(
            $table_names[4],
            array(
                'ID' => 3,
                'status' => 'Afgehandeld'
            )
        );

    }

    /**
     * removeDBTables
     * 
     * Remove the automatically created tables when plugin is deactivated
    */
    // public static function removeDBTables() {

    //     global $wpdb;

    //     // Include the IVS_Databases class
    //     require_once IVS_MEELOOP_PORTAAL_PLUGIN_INCLUDES_MODEL_DIR . '/IVS_Databases.php';

    //     // Retrieve the table names
    //     $table_names = IVS_Databases::retrieveTables();

    //     // Loop over each $table
    //     foreach( $table_names as $table ) {

    //         // Delete query
    //         $query = "DROP TABLE IF EXISTS $table";

    //         // Bypass queries in order for all tables to be deleted
    //         // If not supplied, table 'ivs_mp_email_status' won't be deleted because of foreign key referencing this table
    //         $disable_foreign_key_check = "SET foreign_key_checks = 0;";
    //         $enable_foreign_key_check = "SET foreign_key_checks = 1;";

    //         // Disable the foreign key check
    //         $wpdb->query ( $disable_foreign_key_check );

    //         // Delete tables
    //         $wpdb->query( $query );

    //         // Enable foreign key check to maintain integrity of database
    //         $wpdb->query( $enable_foreign_key_check );

    //     }
        
    // }

}

?>