<?php 
/**
 * Class contains the entire Database SQL query for database setup,
 * when plugin is activated by an Administrator within WordPress
 * 
 * @package DatabaseSetupQueries
 * @author Yari Morcus <ymorcus@student.scalda.nl>
 * @version 0.1
 * @since 5.8.2
*/
class DatabaseSetupQueries {

    /**
     * retrieveTables
     * 
     * Retrieve all table names for creation
     * @return array - Array containing the table names
     * 
    */
    public static function retrieveTables() {

        return array(

            $table_name_1 = 'wp_oliepor_aanvraag',
            $table_name_2 = 'wp_oliepor_status'

        );

    }

    /**
     * setupTableQueries
     * 
     * Setup the SQL query set, used for the creation of the tables
     * 
     * @return string - The string containing the entire SQL query set
     * 
    */
    public static function setupTableQueries() {
    
        // Define $wpdb as a global variable
        global $wpdb;

        /**
         * @var string
         * Holds the database character collate
        */
        $charset_collate = $wpdb->get_charset_collate();

        /**
         * @var array
         * (Retrieves and) holds the table names
        */
        $table_names = DatabaseSetupQueries::retrieveTables();

        /**
         * @var string
         * Holds the entire table query for setup
        */
        $table_queries = "CREATE TABLE $table_names[1] (
            id int(10) NOT NULL AUTO_INCREMENT,
            status varchar(255) NOT NULL,
            PRIMARY KEY  (id)
          ) $charset_collate; 

          CREATE TABLE $table_names[0] (
            monsternummer int(10) NOT NULL,
            fk_wp_oliepor_status_id int(10) NOT NULL DEFAULT 1,
            gebruiker_id int(10) NOT NULL,
            naam_klant varchar(255) NOT NULL,
            naam_schip varchar(56) NOT NULL,
            motor varchar(255) NOT NULL,
            type_motor varchar(255) NOT NULL,
            serienummer varchar(255) NOT NULL,
            soort_onderzoek varchar(255) NOT NULL,
            monster_datum varchar(255) NOT NULL,
            urenstand_motor int(10) NOT NULL,
            merk_olie varchar(255) NOT NULL,
            type_olie varchar(255) NOT NULL,
            urengebruik_olie int(10) NOT NULL,
            olie_ververst varchar(255) NOT NULL,
            filters_ververst varchar(255) NOT NULL,
            koelmiddel_gebruikt varchar(255) NOT NULL,
            merk_koelmiddel varchar(255) NOT NULL,
            opmerking varchar(255) DEFAULT NULL,
            PRIMARY KEY  (monsternummer),
            FOREIGN KEY  (fk_wp_oliepor_status_id) REFERENCES $table_names[1] (id)
          ) $charset_collate;
          ";
          
          // Return the above queries for later execution
          return $table_queries;
    
    }
    
}
?>