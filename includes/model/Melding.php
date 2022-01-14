<?php 
/**
 * Class contains the function that sends an automatic e-mail to the site admin
 * when new request has been submitted
 * 
 * @package Melding
 * @author Yari Morcus <ymorcus@student.scalda.nl>
 * @version 0.1
 * @since 5.8.2
*/
class Melding {

    /**
     * verstuurNotificatie
     * 
     * Send the admin of the site an automatic message that a new request for a check has been submitted
     * @param array, array containing filtered user input
     * @return boolean, TRUE on success, otherwise FALSE
    */
    public function verstuurNotificatie( $input_array ) {

        try {

            global $wpdb;

            // Define the e-mail adres where this message has to be send to
            $emailadres = get_option( 'admin_email' );

            // Define the subject
            $subject = $input_array[ 'klantnaam'] . " met monsternummer " . $input_array[ 'monsternummer' ] . " heeft nieuwe aanvraag ingediend.";

            // Define the title (<h1>)
            $title = "<h1>" . $input_array[ 'klantnaam'] . " met monsternummer " . $input_array[ 'monsternummer' ] . " heeft nieuwe aanvraag ingediend.</h1>";

            // Form labels
            $form_labels = array( 'Monsternummer', 'Klant', 'Schip', 'Motor', 'Type', 'Serienummer', 'Soort onderzoek', 'Monster datum', 'Urenstand motor', 
            'Merk olie', 'Type olie', 'Urengebruik olie', 'Olie ververst', 'Filters ververst', 'Koelmiddel gebruikt', 'Merk koelmiddel', 'Opmerkingen');

            // Load the model
            require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/AanvragenControle.php';

            // Instantiate the class
            $aanvragen_controle = new AanvragenControle();

            // Retrieve all form field names
            $field_names = $aanvragen_controle->getAllFormFieldNames();

            // Remove the first field name (gebruiker-id).
            // Gebruiker-id won't be shown in the e-mail
            array_shift( $field_names );

            // Create opening HTML tags
            $table_open = $title . "<table><tbody>";

            // Create closing HTML tags
            $table_closed = "</tbody></table>";
            
            // Copy the $form_labels array and put the internal pointer to the end of the array,
            // to retrieve the last index later on (this happens in the elseif, within foreach) 
            $form_labels_end_pointer = $form_labels;
            end($form_labels_end_pointer);

            // Loop over all the labels with their corresponding index and label name
            foreach($form_labels as $idx => $form_label) {

                //Define the row
                $row = "<tr><th>" . $form_label . "</th><td>" . $input_array[$field_names[$idx]] . "</td></tr>";
                
                // If index is zero, insert the table and tbody HTML tags
                if ($idx == 0) {

                    $table_open .= $row;

                } elseif ( $idx == key($form_labels_end_pointer)  ) { // If it is the last index, insert the closing table and tbody tags
                   
                    $table_open .= $row;
                    $table_open .= $table_closed;

                } else { // If none of the above, insert ONLY the row

                    $table_open .= $row;

                }

            }

            $message = $table_open;

            // Define the headers
            $headers = array( 'Content-Type: text/html; charset=UTF-8' );

            // Send the email and store the result TRUE or FALSE for further processing
            $mail = wp_mail( $emailadres, $subject, $message, $headers );

            // If mail has been send succesfully
            if ($mail) {
                
                return TRUE;

            }

        } catch(Exception $exc) {

            $this->last_error = $wpdb->last_error;
            echo $exc->getMessage();

            return FALSE;
        }

    }

}