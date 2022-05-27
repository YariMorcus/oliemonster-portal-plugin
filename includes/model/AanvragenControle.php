<?php 
/**
 * Class contains every functionality associated to requesting a check
 * @author Yari Morcus
 * @version 0.1
*/
class AanvragenControle {

    // Attributes of the class
    public $monsternummer = 0;
    public $status_id = 0;
    public $gebruiker_id = 0;
    public $naam_klant = '';
    public $naam_schip = '';
    public $motor = '';
    public $type_motor = '';
    public $serienummer = '';
    public $soort_onderzoek = '';
    public $monster_datum = '';
    public $urenstand_motor = 0;
    public $merk_olie = '';
    public $type_olie = '';
    public $urengebruik_olie = 0;
    public $olie_ververst = '';
    public $filters_ververst = '';
    public $koelmiddel_gebruikt = '';
    public $merk_koelmiddel = '';
    public $opmerking = '';

    /**
     * getPostValues
     * 
     * @return array, array of filtered input fields
     * 
    */
    public function getPostValues() {

        /**
         * @var array
         * Holds the arguments of the form including the filter type
        */
        $post_check_array = array(

            // Submit button
            'submit' => array( 'filter', FILTER_SANITIZE_STRING ),

            // Update button
            'update' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Gebruiker id field
            'gebruiker-id' => array( 'filter', FILTER_SANITIZE_STRING ),

            // Monsternummer field
            'monsternummer' => array( 'filter', FILTER_VALIDATE_INT ),

            // Status aanvraag
            'status-aanvraag' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Klantnaam field
            'klantnaam' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Schipnaam field
            'Schipnaam' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Motor field
            'motor' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Type motor field
            'type-motor' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Serienummer field
            'serienummer' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Soort onderzoek field
            'soort-onderzoek' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Monster datum field
            'monster-datum' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Urenstand motor field
            'urenstand-motor' => array( 'filter', FILTER_VALIDATE_INT ),
            
            // Merk olie field
            'merk-olie' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Type olie field
            'type-olie' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Urengebruik olie field
            'urengebruik-olie' => array( 'filter', FILTER_VALIDATE_INT ),
            
            // Olie ververst field
            'olie-ververst' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Filters ververst field
            'filters-ververst' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Koelmiddel gebruikt field
            'koelmiddel-gebruikt' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Merk koelmiddel field
            'merk-koelmiddel' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Opmerking field
            'opmerking' => array( 'filter', FILTER_SANITIZE_STRING ),
            

        );

        /**
         * @var array
         * Holds the filtered data
        */
        $filtered_input = filter_input_array( INPUT_POST, $post_check_array );

        // Return filtered input
        return $filtered_input;

    }

    /**
     * getGetValues
     * 
     * @return array containing the filtered GET input fields
     * 
    */
    public function getGetValues() {

        /**
         * @var array
         * Holds the arguments of the update form url including the filter type
        */
        $get_check_array = array(

            // Action
            'action' => array( 'filter', FILTER_SANITIZE_STRING ),

            // Current monsternummer
            'monsternummer' => array( 'filter', FILTER_SANITIZE_STRING ),

        );

        /**
         * @var array
         * Holds the filtered url data
        */
        $filtered_input = filter_input_array( INPUT_GET, $get_check_array );

        // Return the input
        return $filtered_input;
        
    }

    /**
     * handleGetAction
     * 
     * Check the action and perform action on :
     * - update
     * 
     * @param array $get_array contains all get vars and values
     * @return string action provided by $_GET array
     * 
    */
    public function handleGetAction( $get_array ) {

        /**
         * @var string
         * Functions as placeholder at this moment
        */
        $action = '';

        /**
         * Check which action is being performed by the user
         * Based on the performed action, decide what to do
        */
        switch( $get_array['action'] ) {

            // If user is performing an update:
            case 'update':

                // Indicate current action if monsternummer has been supplied
                if ( !is_null( $get_array['monsternummer'] ) ) {

                    /**
                     * @var string
                     * Fill the variable with the current action being performed by the user
                    */
                    $action = $get_array['action'];

                }
            break;

        }

        // Return the action
        return $action;

    }

    /**
     * getAllFormFieldNames
     * 
     * @return array, array containing all the field names
     * 
    */
    public function getAllFormFieldNames() {

        /**
         * @var array
         * Holds all the field names for future usage
        */
        $field_names = array( 'monsternummer', 'gebruiker-id', 'klantnaam', 'Schipnaam', 'motor', 'type-motor', 'serienummer', 'soort-onderzoek', 'monster-datum', 'urenstand-motor', 'merk-olie', 'type-olie', 'urengebruik-olie', 'olie-ververst', 'filters-ververst', 'koelmiddel-gebruikt', 'merk-koelmiddel', 'opmerking' );

        // Return the field names
        return $field_names;

    }

    /**
     * save
     * 
     * @global $wpdb, the WordPress Database Interface
     * @param array, array containing filtered user input
     * @param boolean, TRUE if it is an update query, otherwise FALSE (FALSE = when user requests new check for their oil)
     * @param int, the monsternummer
     * @return boolean, TRUE on success, otherwise FALSE
     * 
    */
    public function save( $input_array, $update = FALSE, $monsternummer = null ) {

        try {
        
            /**
             * @var array
             * (Retrieve and) holds all the field names
            */
            $field_names = $this->getAllFormFieldNames();

            /**
             * If user is updating information:
             * Remove the submit, update field and add status-aanvraag field
             * Otherwise information won't be updated due to missing fields
             */
            if ( $update ) {

                // Remove the gebruiker-id and monsternummer field
                // Both fields should never be updated
                array_shift( $field_names );
                array_shift( $field_names );

                // Add the status-aanvraag field name to array
                // Field is only visible for administrators
                array_unshift( $field_names, 'status-aanvraag' );

                // Remove the submit, update, gebruiker-id and monsternummer field
                // All four fields should never be updated
                array_splice( $input_array, 0, 4 );

            }

            // Loop over all the field names, and check whether they are NOT set OR empty
            // Otherwise, throw error
            foreach( $field_names as $field_name) {

                if ( $field_name === $field_names[ count( $field_names ) - 1 ] ) continue; // Comment field is optional, and therefore should not throw an error :D

                if ( ! isset( $input_array[ $field_name ] ) ) {

                    // Throw an error if required field is missing
                    throw new Exception( __( 'Verplicht veld mist' ) );

                }

                if ( strlen( $input_array[ $field_name ] ) < 1 ) {

                    // Throw an error if required field is empty
                    throw new Exception( __( '<div class="veld-leeg">Verplicht veld is niet ingevuld.<br>Vul de informatie in, en sla opnieuw op.</div>' ) );

                }
    
            }
            
            // Define $wpdb as a global variable
            global $wpdb;

            // Get access tot he DatabaseSetupQueries class for table retrieval
            require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/DatabaseSetupQueries.php';

            /**
             * @var string
             * (Retrieve and) hold the table name (wp_oliepor_aanvraag) for future usage
            */
            $wp_oliepor_aanvraag_table_name = DatabaseSetupQueries::retrieveTables()[0]; 

            // If user is requesting a new check and NOT updating it, use an insert MySQL query
            // Otherwise it is an update, and then use an update MySQL query
            if ( !$update ) {

                /**
                 * @var string
                 * Holds the insert query
                */
                $query = "INSERT INTO $wp_oliepor_aanvraag_table_name (monsternummer, gebruiker_id, naam_klant, naam_schip, motor, type_motor, serienummer, soort_onderzoek, monster_datum, urenstand_motor, merk_olie, type_olie, urengebruik_olie, olie_ververst, filters_ververst, koelmiddel_gebruikt, merk_koelmiddel, opmerking) VALUES( %d, %d, %s, %s, %s, %s, %s, %s, %s, %d, %s, %s, %d, %s, %s, %s, %s, %s );";

                // Execute query
                $wpdb->query( 
                    $wpdb->prepare(
                        $query,
                        $input_array[ $field_names[0] ], // monsternummer (primary key!, does NOT contain an AUTO_INCREMENT)
                        $input_array[ $field_names[1] ], // gebruiker_id
                        $input_array[ $field_names[2] ], // klantnaam
                        $input_array[ $field_names[3] ], // schipnaam
                        $input_array[ $field_names[4] ], // motor
                        $input_array[ $field_names[5] ], // type-motor
                        $input_array[ $field_names[6] ], // serienummer
                        $input_array[ $field_names[7] ], // soort-onderzoek
                        $input_array[ $field_names[8] ], // monster-datum
                        $input_array[ $field_names[9] ], // urenstand-motor
                        $input_array[ $field_names[10] ], // merk-olie
                        $input_array[ $field_names[11] ], // type-olie
                        $input_array[ $field_names[12] ], // urengebruik-olie
                        $input_array[ $field_names[13] ], // olie-ververst
                        $input_array[ $field_names[14] ], // filters-ververst
                        $input_array[ $field_names[15] ], // koelmiddel-gebruikt
                        $input_array[ $field_names[16] ], // merk-koelmiddel
                        $input_array[ $field_names[17] ] // opmerking
                    )
                );

            } else {

                /**
                 * @var string
                 * Holds the update query
                 * 
                 * More information:
                 * - Format: UPDATE table_name SET column1=value, coliumn2=value, ... WHERE some_column=some_value
                 * - Source: https://www.w3schools.com/php/php_mysql_update.asp
                */
                $update_query = "UPDATE $wp_oliepor_aanvraag_table_name SET 
                `fk_wp_oliepor_status_id` = '%d', 
                `naam_klant` = '%s',
                `naam_schip` = '%s',
                `motor` = '%s',
                `type_motor` = '%s',
                `serienummer` = '%s',
                `soort_onderzoek` = '%s',
                `monster_datum` = '%s',
                `urenstand_motor` = '%s',
                `merk_olie` = '%s',
                `type_olie` = '%s',
                `urengebruik_olie` = '%s',
                `olie_ververst` = '%s',
                `filters_ververst` = '%s',
                `koelmiddel_gebruikt` = '%s',
                `merk_koelmiddel` = '%s',
                `opmerking` = '%s'
                WHERE `monsternummer` = $monsternummer";

                // Update query
                $wpdb->query(
                    $wpdb->prepare(
                        $update_query,
                        $input_array[ $field_names[0] ], // status-aanvraag
                        $input_array[ $field_names[1] ], // klantnaam
                        $input_array[ $field_names[2] ], // schipnaam
                        $input_array[ $field_names[3] ], // motor
                        $input_array[ $field_names[4] ], // type-motor
                        $input_array[ $field_names[5] ], // serienummer
                        $input_array[ $field_names[6] ], // soort-onderzoek
                        $input_array[ $field_names[7] ], // monster-datum
                        $input_array[ $field_names[8] ], // urenstand-motor
                        $input_array[ $field_names[9] ], // merk-olie
                        $input_array[ $field_names[10] ], // type-olie
                        $input_array[ $field_names[11] ], // urengebruik-olie
                        $input_array[ $field_names[12] ], // olie-ververst
                        $input_array[ $field_names[13] ], // filters-ververst
                        $input_array[ $field_names[14] ], // koelmiddel-gebruikt
                        $input_array[ $field_names[15] ], // merk-koelmiddel
                        $input_array[ $field_names[16] ] // opmerking
                    )
                );

            }


             // Error? It is in there:
             if ( ! empty( $wpdb->last_error ) ) {

                // Save the error for future usage
                $this->last_error = $wpdb->last_error;

                // Return FALSE to indicate error
                return FALSE;

             }
            
        } catch(Exception $exc) {
            
            // Show the error
            echo $exc->getMessage();
            
        }
        
        // Return TRUE to indicate that nothing went wrong inserting the information
        return TRUE;

    }

    /**
     * update
     * 
     * @param array $input_array contains POST data
     * @param int monsternummer
     * @param boolean indicates whether the update was successful (TRUE) or not (FALSE)
     * 
    */
    public function update( $input_array, $monsternummer ) {

        /**
         * @var boolean
         * Save the new information, and indicate to save function that it is an update with a new input field (status aanvraag)
         * Otherwise form won't be updated because of missing field
         * Var holds the boolean that indicates whether save was succesful or not
        */
        $save_succesful = $this->save( $input_array, TRUE, $monsternummer );

        // Return the boolean value for further processing
        return $save_succesful;

    }

    /**
     * getAllCheckRequests
     * 
     * @return array, array containing the objects holding the already registered request checks
     * 
    */
    public function getAllCheckRequests() {

        // Define $wpdb as a global variable
        global $wpdb;

        // Get access tot he DatabaseSetupQueries class for table retrieval
        require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/DatabaseSetupQueries.php';

        /**
         * @var string
         * (Retrieve and) hold the table name (wp_oliepor_aanvraag) for future usage
        */
        $wp_oliepor_aanvraag_table_name = DatabaseSetupQueries::retrieveTables()[0]; 

        /**
         * @var array
         * Acts as a placeholder
        */
        $return_array = array();

        /**
         * @var array
         * (Retrieve and) holds the results
        */
        $result_array = $wpdb->get_results( "SELECT * FROM $wp_oliepor_aanvraag_table_name", ARRAY_A );

        // For all database results
        foreach( $result_array as $idx => $array ) {

            /**
             * @var object
             * Create a new object
            */
            $aanvraag = new AanvragenControle();

            // Set all information
            $aanvraag->setGebruikerID( $array[ 'gebruiker_id' ] );
            $aanvraag->setStatusID( $array[ 'fk_wp_oliepor_status_id' ] );
            $aanvraag->setMonsternummer( $array[ 'monsternummer' ] );
            $aanvraag->setNaamKlant( $array[ 'naam_klant' ] );
            $aanvraag->setNaamSchip( $array[ 'naam_schip' ] );
            $aanvraag->setMotor( $array[ 'motor' ] );
            $aanvraag->setTypeMotor( $array[ 'type_motor' ] );
            $aanvraag->setSerienummer( $array[ 'serienummer' ] );
            $aanvraag->setSoortOnderzoek( $array[ 'soort_onderzoek' ] );
            $aanvraag->setMonsterDatum( $array[ 'monster_datum' ] );
            $aanvraag->setUrenstandMotor( $array[ 'urenstand_motor' ] );
            $aanvraag->setMerkOlie( $array[ 'merk_olie' ] );
            $aanvraag->setTypeOlie( $array[ 'type_olie' ] );
            $aanvraag->setUrengebruikOlie( $array[ 'urengebruik_olie' ] );
            $aanvraag->setOlieVerverst( $array[ 'olie_ververst' ] );
            $aanvraag->setFiltersVerverst( $array[ 'filters_ververst' ] );
            $aanvraag->setKoelmiddelGebruikt( $array[ 'koelmiddel_gebruikt' ] );
            $aanvraag->setMerkKoelmiddel( $array[ 'merk_koelmiddel' ] );
            $aanvraag->setOpmerking( $array[ 'opmerking' ] );

            /**
             * @var array
             * Holds all the objects that have been setup above this variable
            */
            $return_array[] = $aanvraag;

        }

        // Return the array holding the objects
        return $return_array;

    }

    /**
     * getGebruikerID
     * 
     * @return int, user ID
     * 
    */
    public function getGebruikerID() {

        return $this->gebruiker_ID;

    }

    /**
     * getStatusID
     * 
     * @return int, the status ID
     * 
    */
    public function getStatusID() {

        return $this->status_id;

    }

    /**
     * setGebruikerID
     * 
     * @param int, set the user ID
     * if ( is_int( intval( $gebruiker_id ) ), first get the integer value of the variable, then check if it is an integer before saving it
     * 
    */
    public function setGebruikerID( $gebruiker_id ) {

        if ( is_int( intval( $gebruiker_id ) ) ) {

            $this->gebruiker_id = $gebruiker_id;

        }

    }

    /**
     * setStatusID
     * 
     * @param int, set the ID of the status
     * if ( is_int( intval( $status_id ) ), first get the integer value of the variable, then check if it is an integer before saving it
     * 
    */
    public function setStatusID( $status_id ) {

        if ( is_int( intval( $status_id ) ) ) {

            $this->status_id = $status_id;

        }

    }

    /**
     * getMonsternummer
     * 
     * @return int, sample number
    */
    public function getMonsternummer() {

        return $this->monsternummer;

    }

    /**
     * setMonsternummer
     * 
     * @param int, sample number
     * if ( is_int( intval( $monsternummer ) ), first get the integer value of the variable, then check if it is an integer before saving it
     * 
    */
    public function setMonsternummer( $monsternummer ) {

        if ( is_int( intval( $monsternummer ) ) ) {

            $this->monsternummer = $monsternummer;

        }

    }

    /**
     * getNaamKlant
     * 
     * @return string, name of the customer
     * 
    */
    public function getNaamKlant() {

        return $this->naam_klant;

    }

    /**
     * setNaamKlant
     * 
     * @param string, name of the customer
     * if ( is_string( $naam_klant ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setNaamKlant( $naam_klant ) {

        if ( is_string( $naam_klant ) ) {

            $this->naam_klant = trim( $naam_klant );

        }

    }

    /**
     * getNaamSchip
     * 
     * @return string, name of the ship
     * 
    */
    public function getNaamSchip() {

        return $this->naam_schip;

    }

    /**
     * setNaamSchip
     * 
     * @param string, name of the ship
     * if ( is_string( $naam_schip ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setNaamSchip( $naam_schip ) {

        if ( is_string( $naam_schip ) ) {

            $this->naam_schip = trim( $naam_schip );

        }

    }

    /**
     * getMotor
     * 
     * @return string, the engine of the ship
     * 
    */
    public function getMotor() {

        return $this->motor;

    }

    /**
     * setMotor
     * 
     * @param string, the engine of the ship
     * if ( is_string( $motor ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setMotor( $motor ) {

        if ( is_string( $motor ) ) {

            $this->motor = trim( $motor );

        }

    }

    /**
     * getTypeMotor
     * 
     * @return string, engine type
     * 
    */
    public function getTypeMotor() {

        return $this->type_motor;

    }

    /**
     * setTypeMotor
     * 
     * @param string, engine type
     * if ( is_string( $type_motor ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setTypeMotor( $type_motor ) {

        if ( is_string( $type_motor ) ) {

            $this->type_motor = trim( $type_motor );

        }

    }

    /**
     * getSerienummer
     * 
     * @return string, the serial number
     * 
    */
    public function getSerienummer() {

        return $this->serienummer;

    }

    /**
     * setSerienummer
     * 
     * @param string, the serial number
     * if ( is_string( $serienummer ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setSerienummer( $serienummer ) {

        if ( is_string( $serienummer ) ) {

            $this->serienummer = trim( $serienummer );

        }

    }

    /**
     * getSoortOnderzoek
     * 
     * @return string, the type of research requested by the user
     * 
    */
    public function getSoortOnderzoek() {

        return $this->soort_onderzoek;

    }

    /**
     * setSoortOnderzoek
     * 
     * @param string, the type of research requested by the user
     * if ( is_string( $soort_onderzoek ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setSoortOnderzoek( $soort_onderzoek ) {

        if ( is_string( $soort_onderzoek ) ) {

            $this->soort_onderzoek = trim( $soort_onderzoek );

        }

    }

    /**
     * getMonsterDatum
     * 
     * @return string, the sample date
     * 
    */
    public function getMonsterDatum() {

        return $this->monster_datum;

    }

    /**
     * setMonsterDatum
     * 
     * @param string, the sample date
     * if ( is_string( $monster_datum ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setMonsterDatum( $monster_datum ) {

        if ( is_string( $monster_datum ) ) {

            $this->monster_datum = trim( $monster_datum );

        }

    }

    /**
     * getUrenstandMotor
     * 
     * @return int, the engine hours
     * 
    */
    public function getUrenstandMotor() {

        return $this->urenstand_motor;

    }
    
    /**
     * setUrenstandMotor
     * 
     * @param int, the engine hours
     * if ( is_int( intval( $urenstand_motor ) ), first get the integer value of the variable, then check if it is an integer before saving it
     * 
     */
    public function setUrenstandMotor( $urenstand_motor ) {
        
        if ( is_int( intval( $urenstand_motor ) ) ) {
            
            $this->urenstand_motor = $urenstand_motor;
            
        }
        
    }

    /**
     * getMerkOlie
     * 
     * @return string, the brand of the oil
     * 
    */
    public function getMerkOlie() {

        return $this->merk_olie;

    }
    
    /**
     * setMerkOlie
     * 
     * @param string, the brand of the oil
     * if ( is_string( $merk_olie ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setMerkOlie( $merk_olie ) {

        if ( is_string( $merk_olie ) ) {

            $this->merk_olie = trim( $merk_olie );

        }

    }

    /**
     * getTypeOlie
     * 
     * @return string, the oil type
     * 
    */
    public function getTypeOlie() {

        return $this->type_olie;

    }
    
    /**
     * setTypeOlie
     * 
     * @param string, the oil type
     * if ( is_string( $type_olie ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setTypeOlie( $type_olie ) {

        if ( is_string( $type_olie ) ) {

            $this->type_olie = trim( $type_olie );

        }

    }

    /**
     * getUrengebruikOlie
     * 
     * @return int, the hours of use oil
     * 
    */
    public function getUrengebruikOlie() {

        return $this->urengebruik_olie;

    }
   
    /**
     * setUrengebruikOlie
     * 
     * @param int, the hours of use oil
     * if ( is_int( intval( $urengebruik_olie ) ), first get the integer value of the variable, then check if it is an integer before saving it
     * 
     */
    public function setUrengebruikOlie( $urengebruik_olie ) {
        
        if ( is_int( intval( $urengebruik_olie ) ) ) {
            
            $this->urengebruik_olie = $urengebruik_olie;
            
        }
        
    }

    /**
     * getOlieVerverst
     * 
     * @return string, id that indicates if oil has been refreshed or not (1 for YES and 2 for NO)
     * 
    */
    public function getOlieVerverst() {

        return $this->olie_ververst;

    }
   
    /**
     * setOlieVerverst
     * 
     * @param string, string that indicates if oil has been refreshed or not (1 for YES and 2 for NO)
     * if ( is_string( $olie_ververst ) ), check whether the given value is a string, if yes, save it
     * 
     */
    public function setOlieVerverst( $olie_ververst ) {
        
        if ( is_string( $olie_ververst ) ) {
            
            $this->olie_ververst = trim( $olie_ververst );
            
        }
        
    }

    /**
     * getFiltersVerverst
     * 
     * @return string, id that indicates if filters has been refreshed or not (1 for YES and 2 for NO)
     * 
    */
    public function getFiltersVerverst() {

        return $this->filters_ververst;

    }
   
    /**
     * setFiltersVerverst
     * 
     * @param string, id that indicates if filters has been refreshed or not (1 for YES and 2 for NO)
     * if ( is_string( $filters_ververst ) ), check whether the given value is a string, if yes, save it
     * 
     */
    public function setFiltersVerverst( $filters_ververst ) {
        
        if ( is_string( $filters_ververst ) ) {
            
            $this->filters_ververst = trim( $filters_ververst );
            
        }
        
    }

    /**
     * getKoelmiddelGebruikt
     * 
     * @return string, id that indicates if refrigerant has been refreshed or not (1 for YES and 2 for NO)
     * 
    */
    public function getKoelmiddelGebruikt() {

        return $this->koelmiddel_gebruikt;

    }
   
    /**
     * setKoelmiddelGebruikt
     * 
     * @param string, id that indicates if refrigerant has been refreshed or not (1 for YES and 2 for NO)
     *  if ( is_string( $koelmiddel_gebruikt ) ), check whether the given value is a string, if yes, save it
     * 
     */
    public function setKoelmiddelGebruikt( $koelmiddel_gebruikt ) {
        
        if ( is_string( $koelmiddel_gebruikt ) ) {
            
            $this->koelmiddel_gebruikt = trim( $koelmiddel_gebruikt );
            
        }
        
    }

    /**
     * getMerkKoelmiddel
     * 
     * @return string, the brand of the refrigerant
     * 
    */
    public function getMerkKoelmiddel() {

        return $this->merk_koelmiddel;

    }
        
    /**
     * setMerkKoelmiddel
     * 
     * @param string, the brand of the refrigerant
     * if ( is_string( $merk_koelmiddel ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setMerkKoelmiddel( $merk_koelmiddel ) {

        if ( is_string( $merk_koelmiddel ) ) {

            $this->merk_koelmiddel = trim( $merk_koelmiddel );

        }

    }

    /**
     * getOpmerking
     * 
     * @return string, optional comment of the user
     * 
    */
    public function getOpmerking() {

        return $this->opmerking;

    }
        
    /**
     * setOpmerking
     * 
     * @param string, optional comment of the user
     * if ( is_string( $opmerking ) ), check whether the given value is a string, if yes, save it
     * 
    */
    public function setOpmerking( $opmerking ) {

        if ( is_string( $opmerking ) ) {

            $this->opmerking = trim( $opmerking );

        }

    }

    /**
     * generateRandomSampleNumber
     * 
     * @return int, random generated sample number
     * 
    */
    public function generateRandomSampleNumber() {

        /**
         * @var int
         * (Generates and) holds a random sample number
        */
        $sample_number = random_int( 0, 9999999 );

        // Return the sample number
        return $sample_number;

    }

    /**
     * generateRandomSampleNumber
     * 
     * @global $wpdb, WordPress Database Interface
     * @param int, random generated sample number
     * @return boolean, indicate whether sample number already exists or not
     * 
    */
    public function doesSampleNumberExist( $sample_number ) {

        // Define $wpdb as a global variable
        global $wpdb;

        // Get access tot he DatabaseSetupQueries class for table retrieval
        require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/DatabaseSetupQueries.php';

        /**
         * @var string
         * (Retrieve and) hold the table name (wp_oliepor_aanvraag) for future usage
        */
        $wp_oliepor_aanvraag_table_name = DatabaseSetupQueries::retrieveTables()[0]; 

        /**
         * @var string
         * Holds the setup query for future usage
        */
        $query = "SELECT EXISTS( SELECT `monsternummer` FROM `$wp_oliepor_aanvraag_table_name` WHERE`monsternummer` = %d) 
        AS `gevonden`";

        /**
         * @var array
         * Array holds an object
        */
        $result = $wpdb->get_results( $wpdb->prepare( $query, $sample_number ), OBJECT );

        // If sample number exists, return TRUE, otherwise FALSE
        // 1 indicates TRUE, 0 FALSE
        if ( $result[0]->gevonden === 1 ) {

            return TRUE;

        } else {

            return FALSE;

        }

    }

    /**
     * getInformationSpecificRequest
     * 
     * @global wpdb, the WordPress Database Interface
     * @param int, the monsternummer used to get the information out of the database
     * @return object, object containing the information. If no information could be found, return FALSE
     * 
    */
    public function getInformationSpecificRequest( $monsternummer ) {

        // Define $wpdb as a global variable
        global $wpdb;

        // Get access tot he DatabaseSetupQueries class for table retrieval
        require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/DatabaseSetupQueries.php';

        /**
         * @var string
         * (Retrieve and) hold the table name (wp_oliepor_aanvraag) for future usage
        */
        $wp_oliepor_aanvraag_table_name = DatabaseSetupQueries::retrieveTables()[0];         

        /**
         * @var string
         * Holds the setup query for future usage
        */
        $query = "SELECT * FROM $wp_oliepor_aanvraag_table_name WHERE `monsternummer` = %d";

        /**
         * @var array
         * Array holds an object containing all the information about a specific request based on the given monsternummer
         * get_row is used because we only want ONE row to be returned (there CANNOT be more than 1 row with the same monsternummer)
        */
        $result = $wpdb->get_row( $wpdb->prepare( $query, $monsternummer ), OBJECT );

        // If WordPress could get the corresponding information, return the information
        // Otherwise, return FALSE
        if ( $result ) {

            return $result;

        } else {

            return FALSE;

        }


    }

    /**
     * verstuurNotificatie
     * 
     * Send the admin of the site an automatic message that a new request for a check has been submitted
     * @param array, array containing filtered user input
     * @return boolean, TRUE on success, otherwise FALSE
     * 
    */
    public function verstuurNotificatie( $input_array ) {

        try {

            // Define $wpdb as a global variable       
            global $wpdb;

            /**
             * @var string
             * Holds the admin e-mail 
            */
            $emailadres = get_option( 'admin_email' );

            /**
             * @var string
             * Define and holds the subject of the e-mail
            */
            $subject = $input_array[ 'klantnaam'] . " met monsternummer " . $input_array[ 'monsternummer' ] . " heeft nieuwe aanvraag ingediend.";

            /**
             * @var string
             * Define and holds the title (<h1>) of the e-mail
            */
            $title = "<h1>" . $input_array[ 'klantnaam'] . " met monsternummer " . $input_array[ 'monsternummer' ] . " heeft nieuwe aanvraag ingediend.</h1>";

            /**
             * @var array
             * Holds the form labels for future usage
            */
            $form_labels = array( 'Monsternummer', 'Klant', 'Schip', 'Motor', 'Type', 'Serienummer', 'Soort onderzoek', 'Monster datum', 'Urenstand motor', 
            'Merk olie', 'Type olie', 'Urengebruik olie', 'Olie ververst', 'Filters ververst', 'Koelmiddel gebruikt', 'Merk koelmiddel', 'Opmerkingen');

            // Load the model
            require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/AanvragenControle.php';

            /**
             * @var object
             * Instantiate the class
            */
            $aanvragen_controle = new AanvragenControle();

            /**
             * @var array
             * (Retrieves and) holds all the field names
            */
            $field_names = $aanvragen_controle->getAllFormFieldNames();

            // Remove the first field name (gebruiker-id).
            // Gebruiker-id won't be shown in the e-mail
            // array_shift( $field_names );

            array_splice( $field_names, 1, 1 );

            /**
             * @var string
             * Holds the opening HTML tags for the table
            */
            $table_open = $title . "<table><tbody>";

            /**
             * @var string
             * Holds the closing HTML tags for the table
            */
            $table_closed = "</tbody></table>";
            
            // Copy the $form_labels array and put the internal pointer to the end of the array,
            // to retrieve the last index later on (this happens in the elseif, within foreach) 
            $form_labels_end_pointer = $form_labels;
            end($form_labels_end_pointer);

            // Loop over all the labels with their corresponding index and label name
            foreach($form_labels as $idx => $form_label) {

                /**
                 * Check if field names is one of the following:
                 * • Olie ververst
                 * • Filters ververst
                 * • Koelmiddel gebruikt
                 * 
                 * If yes, assign the corresponding YES or NO answer (based in it's given number)
                 * If it isn't one of the fields above, then make up a regular row (without converting)
                 */

                switch( $field_names[$idx] ) {
                    case 'olie-ververst':
                    case 'filters-ververst':
                    case 'koelmiddel-gebruikt':

                        // If given number is 1, convert it to YES
                        // If given number is 0, convert it to NO
                        if ( $input_array[$field_names[$idx]] == 1 ) {

                            /**
                             * @var string
                             * Holds a new row of information (either olie-ververst, filters-ververst of koelmiddel-gebruikt with value Ja)
                            */
                            $row = "<tr><th>" . $form_label . "</th><td>Ja</td></tr>";
                            
                        } else {

                            /**
                             * @var string
                             * Holds a new row of information (either olie-ververst, filters-ververst of koelmiddel-gebruikt with value Nee)
                            */
                            $row = "<tr><th>" . $form_label . "</th><td>Nee</td></tr>";
                        }

                        break;
                    default:

                        /**
                         * @var string
                         * Holds a new row of information
                        */
                        $row = "<tr><th>" . $form_label . "</th><td>" . $input_array[$field_names[$idx]] . "</td></tr>";

                    break;
                }
                
                // If index is zero, insert the table and tbody HTML tags
                if ($idx == 0) {

                    /**
                     * @var string
                     * Holds the entire table, but adds the table and tbody HTML tags here
                     */ 
                    $table_open .= $row;

                } elseif ( $idx == key($form_labels_end_pointer)  ) { // If it is the last index, insert the closing table and tbody tags
                   
                    /**
                     * @var string
                     * Holds the entire table, but adds the closing table and tbody HTML tags here
                    */
                    $table_open .= $row;
                    $table_open .= $table_closed;

                } else { // If none of the above, insert ONLY the row

                    /**
                     * @var string
                     * Holds the entire table, but adds a new row of information to it
                    */
                    $table_open .= $row;

                }

            }

            /**
             * @var string
             * Contains the entire table that has been setup in the above foreach
            */
            $message = $table_open;

            /**
             * @var array
             * Defines the headers for the e-mail
            */
            $headers = array( 'Content-Type: text/html; charset=UTF-8' );

            /**
             * @var boolean
             * Indicate whether e-mail has been send succesfully or not
             * Sending e-mail is being done here
            */
            $mail = wp_mail( $emailadres, $subject, $message, $headers );

            // If mail has been send succesfully
            if ($mail) {
                
                // Return true to indicate that e-mail has been send succesfully
                return TRUE;

            }

        } catch(Exception $exc) {

            // Save the error for future usage
            $this->last_error = $wpdb->last_error;

            // Show the error message to the user
            echo $exc->getMessage();

            // Return false to indicate that something went wrong
            return FALSE;
        }

    }
}

?>