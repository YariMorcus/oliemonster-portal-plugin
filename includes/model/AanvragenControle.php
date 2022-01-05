<?php 
/**
 * Class contains every functionality associated to requesting a check
 * @author Yari Morcus
 * @version 0.1
*/

class AanvragenControle {

    //
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

}

?>