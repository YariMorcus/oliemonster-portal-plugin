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
     * 
     * @param array, array containing filtered user input
     * @return boolean, TRUE on success, otherwise FALSE
    */
    public function save( $input_array ) {


    }

    /**
     * getAllCheckRequests
     * 
    */
    public function getAllCheckRequests() {

        global $wpdb;

        $return_array = array();

        $result_array = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "oliepor_controle_aanvragen", ARRAY_A );

        echo __FILE__ . __LINE__ . '<br>';
        echo '<pre>';
        var_dump($result_array);
        echo '</pre>';

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

}

?>