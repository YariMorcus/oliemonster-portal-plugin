<?php 

// Set base url for this page
$base_url = get_admin_url() . 'admin.php';

// If URL contains controle_id, show the page, otherwise redirect user back to dashboard
if ( isset( $_GET['controle_id'] ) ) {
    
    // Sanitize the controle ID and save it for further usage
    $controle_id = filter_var( $_GET['controle_id'], FILTER_SANITIZE_STRING  );

    // Convert controle_id from string to int
    $controle_id = intval( $controle_id );

    // Include the model
    require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/AanvragenControle.php';

    // Declare class variable
    $aanvragen_controle = new AanvragenControle();

    // Retrieve all data for given controle_ID
    // $information_request is an object
    // Information can be accessed by $information_request->[name-of-the-attribute-in-db-table]
    $information_request = $aanvragen_controle->getInformationSpecificRequest( $controle_id );
    
    ?>
        <div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-lg-3">
                    <img src="<?php echo plugin_dir_url( dirname( __DIR__ ) ); ?>/admin/assets/img/logo-oliemonster.jpg"
                    alt="" class="img-fluid d-block mx-auto" width="140" height="79">
                </div> <!-- .col-md-2 -->
                <div class="col-md-10 col-lg-7">
                    <h1 class="h1 mb-4">Aanvraag controle monsternummer: <?php echo $information_request->monsternummer; ?></h1>
                    <p class="mb-4">
                    Deze pagina geeft de ingevulde gegevens weer van monsternummer <?php echo $information_request->monsternummer; ?>.
                    </p> <!-- .mb-4 -->
                    <p class="mb-4 d-lg-none">
                    Houdt er rekening mee dat op mobiel deze gegevens niet bewerkt kunnen worden.
                    </p>
                    <form action="<?php echo $base_url; ?>" method="POST" class="needs-validation" novalidate>
                        <input name="gebruiker-id" type="hidden" required readonly class="form-control-plain-text w-100" id="gebruiker-id" value="<?php echo get_current_user_id(); ?>">
                        <div class="form-group row mb-3">
                            <label for="monsternummer" class="col-sm-3 col-form-label">Monsternummer</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="monsternummer" type="number" required readonly class="form-control-plain-text w-100" id="monsternummer" aria-describedby="monsternummer-help" value="<?php echo $information_request->monsternummer; ?>">
                                <small id="monsternummer-help" class="form-text text-muted d-block">U kunt dit nummer niet wijzigen. Dit wordt automatisch toegekend.</small>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="status-aanvraag" class="col-sm-3 col-form-label">Status aanvraag</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <select name="status-aanvraag" id="status-aanvraag" required disabled class="custom-select w-100">
                                    <?php 
                                    define( 'SAMPLE_NOG_NIET_ONTVANGEN', 1 );
                                    define( 'IN_BEHANDELING', 2 );
                                    define( 'AFGEHANDELD', 3 );

                                    // If status is 'Sample nog niet ontvangen', show this option element first
                                    if ( intval( $information_request->fk_status_aanvraag_id ) === SAMPLE_NOG_NIET_ONTVANGEN ) {
                                        ?>
                                        <option selected="selected" value="1">Sample nog niet ontvangen</option>
                                        <option value="2">In behandeling</option>
                                        <option value="3">Afgehandeld</option>
                                        <?php
                                    }
                                    
                                    // If status is 'In behandeling', show this option element first
                                    if ( intval( $information_request->fk_status_aanvraag_id ) === IN_BEHANDELING ) {
                                        ?>
                                        <option value="1">Sample nog niet ontvangen</option>
                                        <option selected="selected" value="2">In behandeling</option>
                                        <option value="3">Afgehandeld</option>
                                        <?php
                                    }

                                    // If status is 'Afgehandeld', show this option element first
                                    if ( intval( $information_request->fk_status_aanvraag_id ) === AFGEHANDELD ) {
                                        ?>
                                        <option value="1">Sample nog niet ontvangen</option>
                                        <option value="2">In behandeling</option>
                                        <option selected="selected" value="3">Afgehandeld</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecteer ja of nee.
                                </div>
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="klantnaam" class="col-sm-3 col-form-label">Klant</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="klantnaam" type="text" required readonly class="form-control-plain-text w-100" id="klantnaam" placeholder="Vul hier uw naam in" value="<?php echo $information_request->naam_klant; ?>">
                                <div class="invalid-feedback"> value="<?php echo $information_request->monsternummer; ?>"
                                    Naam niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="Schipnaam" class="col-sm-3 col-form-label">Schip</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="Schipnaam" type="text" required readonly class="form-control-plain-text w-100" id="Schipnaam" placeholder="Vul hier de naam van uw schip in" value="<?php echo $information_request->naam_schip; ?>">
                                <div class="invalid-feedback">
                                    Scheepsnaam niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="motor" class="col-sm-3 col-form-label">Motor</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="motor" type="text" required readonly class="form-control-plain-text w-100" id="motor" placeholder="Vul hier uw motor in" value="<?php echo $information_request->motor; ?>">
                                <div class="invalid-feedback">
                                    Motor niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="type" class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="type-motor" type="text" required readonly class="form-control-plain-text w-100" id="type" placeholder="Vul hier het type in" value="<?php echo $information_request->type_motor; ?>">
                                <div class="invalid-feedback">
                                    Type motor niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="serienummer" class="col-sm-3 col-form-label">Serienummer</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="serienummer" type="text" required readonly class="form-control-plain-text w-100" id="serienummer" placeholder="Vul hier het serienummer in" value="<?php echo $information_request->serienummer; ?>">
                                <div class="invalid-feedback">
                                    Serienummer niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="soort-onderzoek" class="col-sm-3 col-form-label">Soort onderzoek</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="soort-onderzoek" type="text" required readonly class="form-control-plain-text w-100" id="soort-onderzoek" placeholder="Vul hier het soort onderzoek in" value="<?php echo $information_request->soort_onderzoek; ?>">
                                <div class="invalid-feedback">
                                    Soort onderzoek niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="monster-datum" class="col-sm-3 col-form-label">Monster datum</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="monster-datum" type="date" required readonly class="form-control-plain-text w-100" id="monster-datum" placeholder="Vul hier de monster datum in" value="<?php echo $information_request->monster_datum; ?>">
                                <div class="invalid-feedback">
                                    Monster datum niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="urenstand-motor" class="col-sm-3 col-form-label">Urenstand motor</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="urenstand-motor" type="number" required readonly class="form-control-plain-text w-100" id="urenstand-motor" placeholder="Vul hier de urenstand in van de motor" value="<?php echo $information_request->urenstand_motor; ?>">
                                <div class="invalid-feedback">
                                    Urenstand motor niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="merk-olie" class="col-sm-3 col-form-label">Merk olie</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="merk-olie" type="text" required readonly class="form-control-plain-text w-100" id="merk-olie" placeholder="Vul hier het merk in van de olie" value="<?php echo $information_request->merk_olie; ?>">
                                <div class="invalid-feedback">
                                    Merk olie niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="type-olie" class="col-sm-3 col-form-label">Type olie</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="type-olie" type="text" required readonly class="form-control-plain-text w-100" id="type-olie" placeholder="Vul hier het type in van de olie" value="<?php echo $information_request->type_olie; ?>">
                                <div class="invalid-feedback">
                                    Type olie niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="urengebruik-olie" class="col-sm-3 col-form-label">Urengebruik olie</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="urengebruik-olie" type="number" required readonly class="form-control-plain-text w-100" id="urengebruik-olie" placeholder="Vul hier het urengebruik in van de olie" value="<?php echo $information_request->urengebruik_olie; ?>">
                                <div class="invalid-feedback">
                                    Urengebruik olie niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="olie-ververst" class="col-sm-3 col-form-label">Olie ververst</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <select name="olie-ververst" id="olie-ververst" required disabled class="custom-select w-100">
                                    <?php 
                                    define('JA', 1);
                                    define('NEE', 2);

                                    // If user has selected 'Ja' when filling in the form, make the default value 'Ja'
                                    if ( intval( $information_request->fk_olie_ververst_id ) === JA ) {
                                        ?>
                                        <option selected="selected" value="1">Ja</option>
                                        <option value="2">Nee</option>
                                        <?php
                                    }
                                    
                                    // If user has selected 'nee' when filling in the form, make the default value 'Nee'
                                    if ( intval( $information_request->fk_olie_ververst_id ) === NEE ) {
                                        ?>
                                        <option value="1">Ja</option>
                                        <option selected="selected" value="2">Nee</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecteer ja of nee.
                                </div>
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="filters-ververst" class="col-sm-3 col-form-label">Filters ververst</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <select name="filters-ververst" id="filters-ververst" required disabled class="custom-select w-100">
                                    <?php 
                                    // If user has selected 'Ja' when filling in the form, make the default value 'Ja'
                                    if ( intval( $information_request->fk_filters_ververst_id ) === JA ) {
                                        ?>
                                        <option selected="selected" value="1">Ja</option>
                                        <option value="2">Nee</option>
                                        <?php
                                    }
                                    
                                    // If user has selected 'nee' when filling in the form, make the default value 'Nee'
                                    if ( intval( $information_request->fk_filters_ververst_id ) === NEE ) {
                                        ?>
                                        <option value="1">Ja</option>
                                        <option selected="selected" value="2">Nee</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecteer ja of nee.
                                </div>
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="koelmiddel-gebruikt" class="col-sm-3 col-form-label">Koelmiddel gebruikt</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <select name="koelmiddel-gebruikt" id="koelmiddel-gebruikt" required disabled class="custom-select w-100">
                                    <?php 
                                    // If user has selected 'Ja' when filling in the form, make the default value 'Ja'
                                    if ( intval( $information_request->fk_koelmiddel_gebruikt_id ) === JA ) {
                                        ?>
                                        <option selected="selected" value="1">Ja</option>
                                        <option value="2">Nee</option>
                                        <?php
                                    }
                                    
                                    // If user has selected 'nee' when filling in the form, make the default value 'Nee'
                                    if ( intval( $information_request->fk_koelmiddel_gebruikt_id ) === NEE ) {
                                        ?>
                                        <option value="1">Ja</option>
                                        <option selected="selected" value="2">Nee</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecteer ja of nee.
                                </div>
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="merk-koelmiddel" class="col-sm-3 col-form-label">Merk koelmiddel</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <input name="merk-koelmiddel" type="text" required readonly class="form-control-plain-text w-100" id="merk-koelmiddel" placeholder="Vul hier het merk van uw koelmiddel in" value="<?php echo $information_request->merk_koelmiddel; ?>">
                                <div class="invalid-feedback">
                                    Merk koelmiddel niet ingevuld!
                                </div>
                            </div>
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="opmerking" class="col-sm-3 col-form-label">Opmerkingen</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <textarea name="opmerking" readonly class="form-control w-100" id="opmerkingen" rows="10"><?php 
                                if ( empty( $information_request->opmerking ) ) {
                                    ?><?php
                                } else {
                                    echo $information_request->opmerking;
                                } 
                                ?></textarea>
                            </div>
                        </div> <!-- .form-group -->
                    </form>
                </div> <!-- .col-md-10 -->
            </div> <!-- .row -->
        </div> <!-- .container -->
    </div> <!-- .wrap -->
    
    <?php

} else { 
    // If user is trying to gain access to this page WITHOUT a given controle_id, redirect the user
    // back to the dashboard

    // Set redirect URL to dashboard
    $params = array( 'page' => 'oliemonster-portal-admin-dashboard ');
    $redirect_url = add_query_arg( $params, $base_url );

    ?>
    <script>
        // Redirect user back to dashboard
        window.location.replace("<?php echo $redirect_url; ?>");
    </script>
    
    <?php

}
?>