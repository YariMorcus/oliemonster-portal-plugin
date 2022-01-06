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
    */
    public static function retrieveTables() {

        return array(

            $table_name_1 = 'wp_oliepor_controle_aanvragen', 
            $table_name_2 = 'wp_oliepor_filters_ververst',
            $table_name_3 = 'wp_oliepor_koelmiddel_gebruikt',
            $table_name_4 = 'wp_oliepor_olie_ververst',
            $table_name_5 = 'wp_oliepor_status_aanvragen'

        );

    }

    /**
     * setupTableQueries
     * 
     * Setup the SQL query set, used for the creation of the tables
     * 
     * @return string - The string containing the entire SQL query set
    */
    public static function setupTableQueries() {
    
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Retrieve the table names
        $table_names = DatabaseSetupQueries::retrieveTables();

        // Setup the SQL queries for table creations
        $table_queries = "CREATE TABLE $table_names[1] (
            ID int(10) NOT NULL,
            antwoord varchar(10) NOT NULL,
            PRIMARY KEY  (ID)
          ) $charset_collate;

          CREATE TABLE $table_names[2] (
            ID int(10) NOT NULL,
            antwoord varchar(10) NOT NULL,
            PRIMARY KEY  (ID)
          ) $charset_collate;

          CREATE TABLE $table_names[3] (
            ID int(10) NOT NULL,
            antwoord varchar(10) NOT NULL,
            PRIMARY KEY  (ID)
          ) $charset_collate;

          CREATE TABLE $table_names[4] (
            ID int(10) NOT NULL,
            status varchar(255) NOT NULL,
            PRIMARY KEY  (ID)
          ) $charset_collate; 

          CREATE TABLE $table_names[0] (
            controle_ID int(10) NOT NULL AUTO_INCREMENT,
            gebruiker_ID int(10) NOT NULL,
            monsternummer int(10) NOT NULL,
            fk_status_aanvraag_id int(10) NOT NULL DEFAULT 1,
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
            fk_olie_ververst_id int(10) NOT NULL,
            fk_filters_ververst_id int(10) NOT NULL,
            fk_koelmiddel_gebruikt_id int(10) NOT NULL,
            merk_koelmiddel varchar(255) NOT NULL,
            opmerking varchar(255) DEFAULT NULL,
            PRIMARY KEY  (controle_ID),
            FOREIGN KEY  (fk_status_aanvraag_id) REFERENCES $table_names[4] (ID),
            FOREIGN KEY  (fk_olie_ververst_id) REFERENCES $table_names[3] (ID),
            FOREIGN KEY  (fk_filters_ververst_id) REFERENCES $table_names[1] (ID),
            FOREIGN KEY  (fk_koelmiddel_gebruikt_id) REFERENCES $table_names[2] (ID)
          ) $charset_collate;
          ";
          
          return $table_queries;
    
    }
    
}
?>