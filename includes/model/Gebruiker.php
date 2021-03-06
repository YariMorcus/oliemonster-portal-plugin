<?php 
/**
 * Class contains the getter and setter to later on retrieve the user id when requested
 * 
 * @package Gebruiker
 * @author Yari Morcus <ymorcus@student.scalda.nl>
 * @version 0.1
 * @since 5.8.2
*/
class Gebruiker {

    // Class property
    public $gebruiker_id = 0;

    /**
     * getGebruikerID
     * 
     * @return int, the user ID
     * 
    */
    public function getGebruikerID() {

        // Return the user id when function is called
        return $this->gebruiker_id;

    }

    /**
     * setGebruikerID
     * 
     * @param int, the user ID
     * 
    */
    public function setGebruikerID( $gebruiker_id ) {

        // Convert user id to int and check if it is an int
        if ( is_int( intval( $gebruiker_id ) ) ) {

            $this->gebruiker_id = $gebruiker_id;

        }

    }

}

?>