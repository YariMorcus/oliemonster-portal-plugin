<?php 
/**
 * Class contains the function that sends an automatic e-mail to the site admin
 * when new request has been submitted
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
    */
    public function getGebruikerID() {

        return $this->gebruiker_id;

    }

    /**
     * setGebruikerID
     * 
     * @param int, the user ID
    */
    public function setGebruikerID( $gebruiker_id ) {

        if ( is_int( intval( $gebruiker_id ) ) ) {

            $this->gebruiker_id = $gebruiker_id;

        }

    }

}

?>