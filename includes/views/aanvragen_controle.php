<?php

// Include the model
require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/AanvragenControle.php';

// Declare class variable
$aanvragen_controle = new AanvragenControle();

// Set base url to current file and add page specific vars
$base_url = get_admin_url() . 'admin.php';
$params = array( 'page' => basename( __FILE__, '.php' ) );

// Add params to base url
$base_url = add_query_arg( $params, $base_url );

// Get the POST data in filtered array
$post_array = $aanvragen_controle->getPostValues();

// Generate a random sample number
$sample_number = $aanvragen_controle->generateRandomSampleNumber();

// Check whether the sample number already exists
$sample_number_exists = $aanvragen_controle->doesSampleNumberExist( $sample_number );

// Check if sample number already exists
// If yes, generate a new sample number, and check again if it exists
// If it does not exists yet, implement it in the value attr. of the corresponding input element
if ( $sample_number_exists OR strlen($sample_number) < 7 ) {

    $sample_number = $aanvragen_controle->generateRandomSampleNumber();

    $sample_number_exists = $aanvragen_controle->doesSampleNumberExist( $sample_number );    

}

// Check the add form
$add = FALSE;

// Check the POST data  
if ( !empty( $post_array ) ) {


    if ( isset( $post_array['submit'] ) ) {
    
        // Save the user input into the database
        $result = $aanvragen_controle->save( $post_array );
        
        if ( $result ) {
            
            // Save was succesful
            $add = TRUE;

            // Load the model
            require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/Melding.php';

            // Instantiate the class
            $melding = new Melding();

            // Send automatic e-mail to owner of site of newly submitted request for a check
            $melding->verstuurNotificatie( $post_array );
 
        } else {

            // Indicate error
            $error = TRUE;

        }
        
    }

}

?>
<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3">
                <img src="<?php echo plugin_dir_url( dirname( __DIR__ ) ); ?>/admin/assets/img/logo-oliemonster.jpg"
                alt="" class="img-fluid d-block mx-auto" width="140" height="79">
            </div> <!-- .col-md-2 -->
            <div class="col-md-10 col-lg-7">
                <h1 class="h1 mb-4">Aanvragen controle</h1>
                <p class="mb-4">
                Op deze pagina kunt u een controle aanvragen voor uw oliemonster.
                </p> <!-- .mb-4 -->

                <?php 
                if ( ! $add ) { // If form hasn't been submitted by the user, show the form so user can request a new check
                ?>
                <form action="<?php echo $base_url; ?>" method="POST" class="needs-validation" novalidate>
                    <input name="gebruiker-id" type="hidden" required readonly class="form-control-plain-text w-100" id="gebruiker-id" value="<?php echo get_current_user_id(); ?>">
                    <div class="form-group row mb-3">
                        <label for="monsternummer" class="col-sm-3 col-form-label">Monsternummer</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="monsternummer" type="number" required readonly class="form-control-plain-text w-100" id="monsternummer" aria-describedby="monsternummer-help" value="<?php echo $sample_number; ?>">
                            <small id="monsternummer-help" class="form-text text-muted d-block">U kunt dit nummer niet wijzigen. Dit wordt automatisch toegekend.</small>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="klantnaam" class="col-sm-3 col-form-label">Klant</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="klantnaam" type="text" required class="form-control-plain-text w-100" id="klantnaam" placeholder="Vul hier uw naam in">
                            <div class="invalid-feedback">
                                Naam niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="Schipnaam" class="col-sm-3 col-form-label">Schip</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="Schipnaam" type="text" required class="form-control-plain-text w-100" id="Schipnaam" placeholder="Vul hier de naam van uw schip in">
                            <div class="invalid-feedback">
                                Scheepsnaam niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="motor" class="col-sm-3 col-form-label">Motor</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="motor" type="text" required class="form-control-plain-text w-100" id="motor" placeholder="Vul hier uw motor in">
                            <div class="invalid-feedback">
                                Motor niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="type" class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="type-motor" type="text" required class="form-control-plain-text w-100" id="type" placeholder="Vul hier het type in">
                            <div class="invalid-feedback">
                                Type motor niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="serienummer" class="col-sm-3 col-form-label">Serienummer</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="serienummer" type="text" required class="form-control-plain-text w-100" id="serienummer" placeholder="Vul hier het serienummer in">
                            <div class="invalid-feedback">
                                Serienummer niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="soort-onderzoek" class="col-sm-3 col-form-label">Soort onderzoek</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="soort-onderzoek" type="text" required class="form-control-plain-text w-100" id="soort-onderzoek" placeholder="Vul hier het soort onderzoek in">
                            <div class="invalid-feedback">
                                Soort onderzoek niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="monster-datum" class="col-sm-3 col-form-label">Monster datum</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="monster-datum" type="date" required class="form-control-plain-text w-100" id="monster-datum" placeholder="Vul hier de monster datum in">
                            <div class="invalid-feedback">
                                Monster datum niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="urenstand-motor" class="col-sm-3 col-form-label">Urenstand motor</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="urenstand-motor" type="number" required class="form-control-plain-text w-100" id="urenstand-motor" placeholder="Vul hier de urenstand in van de motor">
                            <div class="invalid-feedback">
                                Urenstand motor niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="merk-olie" class="col-sm-3 col-form-label">Merk olie</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="merk-olie" type="text" required class="form-control-plain-text w-100" id="merk-olie" placeholder="Vul hier het merk in van de olie">
                            <div class="invalid-feedback">
                                Merk olie niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="type-olie" class="col-sm-3 col-form-label">Type olie</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="type-olie" type="text" required class="form-control-plain-text w-100" id="type-olie" placeholder="Vul hier het type in van de olie">
                            <div class="invalid-feedback">
                                Type olie niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="urengebruik-olie" class="col-sm-3 col-form-label">Urengebruik olie</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="urengebruik-olie" type="number" required class="form-control-plain-text w-100" id="urengebruik-olie" placeholder="Vul hier het urengebruik in van de olie">
                            <div class="invalid-feedback">
                                Urengebruik olie niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="olie-ververst" class="col-sm-3 col-form-label">Olie ververst</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <select name="olie-ververst" id="olie-ververst" required class="custom-select w-100">
                                <option value="">Selecteer ja of nee</option>
                                <option value="1">Ja</option>
                                <option value="2">Nee</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecteer ja of nee.
                            </div>
                        </div> <!-- .col-sm-9 -->
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="filters-ververst" class="col-sm-3 col-form-label">Filters ververst</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <select name="filters-ververst" id="filters-ververst" required class="custom-select w-100">
                                <option value="">Selecteer ja of nee</option>
                                <option value="1">Ja</option>
                                <option value="2">Nee</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecteer ja of nee.
                            </div>
                        </div> <!-- .col-sm-9 -->
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="koelmiddel-gebruikt" class="col-sm-3 col-form-label">Koelmiddel gebruikt</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <select name="koelmiddel-gebruikt" id="koelmiddel-gebruikt" required class="custom-select w-100">
                                <option value="">Selecteer ja of nee</option>
                                <option value="1">Ja</option>
                                <option value="2">Nee</option>
                            </select>
                            <div class="invalid-feedback">
                                Selecteer ja of nee.
                            </div>
                        </div> <!-- .col-sm-9 -->
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="merk-koelmiddel" class="col-sm-3 col-form-label">Merk koelmiddel</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="merk-koelmiddel" type="text" required class="form-control-plain-text w-100" id="merk-koelmiddel" placeholder="Vul hier het merk van uw koelmiddel in">
                            <div class="invalid-feedback">
                                Merk koelmiddel niet ingevuld!
                            </div>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="opmerking" class="col-sm-3 col-form-label">Opmerkingen</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <textarea name="opmerking" class="form-control w-100" id="opmerkingen" rows="10" placeholder="U kunt hier eventuele opmerkingen kwijt"></textarea>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row">
                        <div class="col-sm-3"></div>
                        <div class="col-xl-6">
                            <button name="submit" type="submit" class="btn mb-3 form-submit-button">Indienen aanvraag controle</button>
                        </div>
                    </div>
                </form>
                <?php 
                } else { // If form has been submitted, inform user

                    // Setup redirect url
                    $params = array( 'page' => 'oliemonster-portal-dashboard' );
                    $redirect_url = add_query_arg( $params, $base_url );
                    ?>
                    <p class="aanvraag-ingediend">Aanvraag succesvol ingediend</p>
                    <script>
                        // Redirect user back to dashboard after 3 seconds
                       setTimeout(() => {
                           window.location.replace("<?php echo $redirect_url; ?>");
                       }, 3000);
                    </script>
                    <?php
                }
                ?>
            </div> <!-- .col-md-10 -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</div> <!-- .wrap -->

<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>