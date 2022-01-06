<?php 
/**
 * Class contains every functionality associated to requesting a check
 * @author Yari Morcus
 * @version 0.1
*/

class AanvragenControle {

    // Class properties
    private $gebruiker_ID = 0;
    private $controle_ID = 0;
    private $monsternummer = 0;
    private $naam_klant = '';
    private $naam_schip = '';
    private $motor = '';
    private $type_motor = '';
    private $serienummer = '';
    private $soort_onderzoek = '';
    private $monster_datum = '';
    private $urenstand_motor = 0;
    private $merk_olie = '';
    private $type_olie = '';
    private $urengebruik_olie = 0;
    private $olie_ververst = 0;
    private $filters_ververst = 0;
    private $koelmiddel_gebruikt = 0;
    private $merk_koelmiddel = '';
    private $opmerking = '';

    /**
     * getPostValues
     * 
     * @return array, array of filtered input fields
    */
    public function getPostValues() {

        // Define the check for params
        $post_check_array = array(

            // Submit button
            'submit' => array( 'filter', FILTER_SANITIZE_STRING ),
            
            // Gebruiker id field
            'gebruiker-id' => array( 'filter', FILTER_SANITIZE_STRING ),

            // Monsternummer field
            'monsternummer' => array( 'filter', FILTER_VALIDATE_INT ),
            
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

        // Filter input
        $filtered_input = filter_input_array( INPUT_POST, $post_check_array );

        // Return filtered input
        return $filtered_input;

    }

    /**
     * save
     * @global $wpdb, the WordPress Database Interface
     * @param array, array containing filtered user input
     * @return boolean, TRUE on success, otherwise FALSE
    */
    public function save( $input_array ) {

        try {

        /*
        TODO: 
            1. DONE - Create an array with all these field names
            2. Loop over the array elements
            3. Check whether fields names are not set OR strlen < 1
            4. If above is yes, throw error

            See Lesopdracht5.pdf for more information (page 5)
        
        */
        
        // Declare all field names
        $field_names = array( 'gebruiker-id', 'monsternummer', 'klantnaam', 'Schipnaam', 'motor', 'type-motor', 'serienummer', 'soort-onderzoek', 'monster-datum', 'urenstand-motor', 'merk-olie', 'type-olie', 'urengebruik-olie', 'olie-ververst', 'filters-ververst', 'koelmiddel-gebruikt', 'merk-koelmiddel', 'opmerking' );

        // Loop over all the field names, and check whether they are NOT set OR empty
        // Otherwise, throw error
        foreach( $field_names as $field_name) {

            if ( ! isset( $input_array[ $field_name ] ) ) {

                throw new Exception( __( 'Verplicht veld mist' ) );

            }

            if ( strlen( $input_array[ $field_name ] ) < 1 ) {

                throw new Exception( __( 'Verplicht veld is leeg' ) );

            }
   
        }

        global $wpdb;

            // Setup insert query
            $query = "INSERT INTO " . $wpdb->prefix . "oliepor_controle_aanvragen (gebruiker_ID, monsternummer, naam_klant, naam_schip, motor, type_motor, serienummer, soort_onderzoek, monster_datum, urenstand_motor, merk_olie, type_olie, urengebruik_olie, fk_olie_ververst_id, fk_filters_ververst_id, fk_koelmiddel_gebruikt_id, merk_koelmiddel, opmerking) VALUES( %d, %d, %s, %s, %s, %s, %s, %s, %s, %d, %s, %s, %d, %d, %d, %d, %s, %s );";

            // Execute query
            $wpdb->query( 
                $wpdb->prepare(
                    $query,
                    $input_array[ $field_names[0] ], // gebruiker_ID (be aware: this is NOT the primary key!)
                    $input_array[ $field_names[1] ], // monsternummer
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

             // Error? It is in there:
             if ( ! empty( $wpdb->last_error ) ) {

                $this->last_error = $wpdb->last_error;
                return FALSE;

             }
            
        } catch(Exception $exc) {
            
            // Shoow the error
            echo $exc->getMessage();
            
        }
        
        return TRUE;

    }

    /**
     * getAllCheckRequests
     * 
     * @return array, array containing the objects holding the already registered request checks
     * 
    */
    public function getAllCheckRequests() {

        global $wpdb;

        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "oliepor_controle_aanvragen", ARRAY_A );

        // echo __FILE__ . __LINE__ . '<br>';
        // echo '<pre>';
        // var_dump($result_array);
        // echo '</pre>';

        // For all database results
        foreach( $result_array as $idx => $array ) {

            // Create new object
            $aanvraag = new AanvragenControle();

            // Set all information
            $aanvraag->setGebruikerID( $array[ 'gebruiker_ID' ] );
            $aanvraag->setControleID( $array[ 'controle_ID' ] );
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
            $aanvraag->setOlieVerverst( $array[ 'fk_olie_ververst_id' ] );
            $aanvraag->setFiltersVerverst( $array[ 'fk_filters_ververst_id' ] );
            $aanvraag->setKoelmiddelGebruikt( $array[ 'fk_koelmiddel_gebruikt_id' ] );
            $aanvraag->setMerkKoelmiddel( $array[ 'merk_koelmiddel' ] );
            $aanvraag->setOpmerking( $array[ 'opmerking' ] );

            // Add new object to array
            $return_array[] = $aanvraag;

        }

        return $return_array;

    }

    /**
     * getGebruikerID
     * 
     * @return int, user ID
    */
    public function getGebruikerID() {

        return $this->gebruiker_ID;

    }

    /**
     * setGebruikerID
     * 
     * @param int, set the user ID
     * if ( is_int( intval( $gebruiker_ID ) ), first get the integer value of the variable, then check if it is an integer before saving it
    */
    public function setGebruikerID( $gebruiker_ID ) {

        if ( is_int( intval( $gebruiker_ID ) ) ) {

            $this->gebruiker_ID = $gebruiker_ID;

        }

    }

    /**
     * getControleID
     * 
     * @return int, controle ID
    */
    public function getControleID() {

        return $this->controle_ID;

    }

    /**
     * setControleID
     * 
     * @param int, controle ID
     * if ( is_int( intval( $controle_ID ) ), first get the integer value of the variable, then check if it is an integer before saving it
    */
    public function setControleID( $controle_ID ) {

        if ( is_int( intval( $controle_ID ) ) ) {

            $this->controle_ID = $controle_ID;

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
    */
    public function getNaamKlant() {

        return $this->naam_klant;

    }

    /**
     * setNaamKlant
     * 
     * @param string, name of the customer
     * if ( is_string( $naam_klant ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getNaamSchip() {

        return $this->naam_schip;

    }

    /**
     * setNaamSchip
     * 
     * @param string, name of the ship
     * if ( is_string( $naam_schip ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getMotor() {

        return $this->motor;

    }

    /**
     * setMotor
     * 
     * @param string, the engine of the ship
     * if ( is_string( $motor ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getTypeMotor() {

        return $this->type_motor;

    }

    /**
     * setTypeMotor
     * 
     * @param string, engine type
     * if ( is_string( $type_motor ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getSerienummer() {

        return $this->serienummer;

    }

    /**
     * setSerienummer
     * 
     * @param string, the serial number
     * if ( is_string( $serienummer ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getSoortOnderzoek() {

        return $this->soort_onderzoek;

    }

    /**
     * setSoortOnderzoek
     * 
     * @param string, the type of research requested by the user
     * if ( is_string( $soort_onderzoek ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getMonsterDatum() {

        return $this->monster_datum;

    }

    /**
     * setMonsterDatum
     * 
     * @param string, the sample date
     * if ( is_string( $monster_datum ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getUrenstandMotor() {

        return $this->urenstand_motor;

    }
    
    /**
     * setUrenstandMotor
     * 
     * @param int, the engine hours
     * if ( is_int( intval( $urenstand_motor ) ), first get the integer value of the variable, then check if it is an integer before saving it
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
    */
    public function getMerkOlie() {

        return $this->merk_olie;

    }
    
    /**
     * setMerkOlie
     * 
     * @param string, the brand of the oil
     * if ( is_string( $merk_olie ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getTypeOlie() {

        return $this->type_olie;

    }
    
    /**
     * setTypeOlie
     * 
     * @param string, the oil type
     * if ( is_string( $type_olie ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getUrengebruikOlie() {

        return $this->urengebruik_olie;

    }
   
    /**
     * setUrengebruikOlie
     * 
     * @param int, the hours of use oil
     * if ( is_int( intval( $urengebruik_olie ) ), first get the integer value of the variable, then check if it is an integer before saving it
     */
    public function setUrengebruikOlie( $urengebruik_olie ) {
        
        if ( is_int( intval( $urengebruik_olie ) ) ) {
            
            $this->urengebruik_olie = $urengebruik_olie;
            
        }
        
    }

    /**
     * getOlieVerverst
     * 
     * @return int, id that indicates if oil has been refreshed or not (1 for YES and 2 for NO)
    */
    public function getOlieVerverst() {

        return $this->olie_ververst;

    }
   
    /**
     * setOlieVerverst
     * 
     * @param int, id that indicates if oil has been refreshed or not (1 for YES and 2 for NO)
     * if ( is_int( intval( $olie_ververst ) ), first get the integer value of the variable, then check if it is an integer before saving it
     */
    public function setOlieVerverst( $olie_ververst ) {
        
        if ( is_int( intval( $olie_ververst ) ) ) {
            
            $this->olie_ververst = $olie_ververst;
            
        }
        
    }

    /**
     * getFiltersVerverst
     * 
     * @return int, id that indicates if filters has been refreshed or not (1 for YES and 2 for NO)
    */
    public function getFiltersVerverst() {

        return $this->filters_ververst;

    }
   
    /**
     * setFiltersVerverst
     * 
     * @param int, id that indicates if filters has been refreshed or not (1 for YES and 2 for NO)
     * if ( is_int( intval( $filters_ververst ) ), first get the integer value of the variable, then check if it is an integer before saving it
     */
    public function setFiltersVerverst( $filters_ververst ) {
        
        if ( is_int( intval( $filters_ververst ) ) ) {
            
            $this->filters_ververst = $filters_ververst;
            
        }
        
    }

    /**
     * getKoelmiddelGebruikt
     * 
     * @return int, id that indicates if refrigerant has been refreshed or not (1 for YES and 2 for NO)
    */
    public function getKoelmiddelGebruikt() {

        return $this->koelmiddel_gebruikt;

    }
   
    /**
     * setKoelmiddelGebruikt
     * 
     * @param int, id that indicates if refrigerant has been refreshed or not (1 for YES and 2 for NO)
     * if ( is_int( intval( $koelmiddel_gebruikt ) ), first get the integer value of the variable, then check if it is an integer before saving it
     */
    public function setKoelmiddelGebruikt( $koelmiddel_gebruikt ) {
        
        if ( is_int( intval( $koelmiddel_gebruikt ) ) ) {
            
            $this->koelmiddel_gebruikt = $koelmiddel_gebruikt;
            
        }
        
    }

    /**
     * getMerkKoelmiddel
     * 
     * @return string, the brand of the refrigerant
    */
    public function getMerkKoelmiddel() {

        return $this->merk_koelmiddel;

    }
        
    /**
     * setMerkKoelmiddel
     * 
     * @param string, the brand of the refrigerant
     * if ( is_string( $merk_koelmiddel ) ), check whether the given value is a string, if yes, save it
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
    */
    public function getOpmerking() {

        return $this->opmerking;

    }
        
    /**
     * setOpmerking
     * 
     * @param string, optional comment of the user
     * if ( is_string( $opmerking ) ), check whether the given value is a string, if yes, save it
    */
    public function setOpmerking( $opmerking ) {

        if ( is_string( $opmerking ) ) {

            $this->opmerking = trim( $opmerking );

        }

    }
}

?>