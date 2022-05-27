<?php 

/**
 * @var string
 * Holds the base url for this page
*/
$base_url = get_admin_url() . 'admin.php';

/**
 * @var string
 * Holds the monsternummer
 * 
 * Check if monsternummer parameter is set, if yes, sanitize the monsternummer and save it for further usage
*/
$monsternummer = isset( $_GET['monsternummer'] ) ? filter_var( $_GET['monsternummer'], FILTER_SANITIZE_STRING ) : null;

// If URL contains monsternummer, show the page, otherwise redirect user back to dashboard
if ( isset( $monsternummer ) && !empty( $monsternummer ) ) {
    
    /**
     * @var int (string --> int conversion)
     * Holds the monsternummer
    */
    $monsternummer = intval( $monsternummer );

    // Include the model
    require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/AanvragenControle.php';

    /**
     * @var object
     * Instantiate the class
    */
    $aanvragen_controle = new AanvragenControle();

    /**
     * @var object
     * Holds (retrieves) all the information about a specific request
     * Information can be accessed by $information_request->[name-of-the-attribute-in-db-table]
    */
    $information_request = $aanvragen_controle->getInformationSpecificRequest( $monsternummer );

    /**
     * @var array
     * Contains the parameters for the form url
    */
    $params = array( 'page' => 'bekijken_gegevens', 'monsternummer' => $monsternummer );

    /**
     * @var string
     * Variable holds the form url
    */
    $form_url = add_query_arg( $params, $base_url );

    // Create update link

    /**
     * @var array
     * Contains the parameters for the update url
    */
    $params = array( 'page' => 'bekijken_gegevens', 'monsternummer' => $monsternummer, 'action' => 'update', );

    /**
     * @var string
     * Variable holds the update url
    */
    $update_link = add_query_arg( $params, $base_url );

    /**
     * @var array
     * Holds the POST data (filtered)
    */
    $post_array = $aanvragen_controle->getPostValues();

    /**
     * @var array
     * Holds the GET data (filtered)
    */
    $get_array = $aanvragen_controle->getGetValues();

    // Check the POST data
    if ( !empty( $post_array ) ) {

        /**
         * @var boolean
         * Set add to FALSE (standard)
        */
        $add = FALSE;

        // Check the update form
        if ( isset( $post_array['update'] ) ) {

            /**
             * @var boolean
             * Holds the boolean that indicates whether save was succesful or not
             * Update the information
            */
            $save_succesful = $aanvragen_controle->update( $post_array, $monsternummer );

            // If the save was succesful, pull the new information out of the database so a page reload isn't necessary to show the updated information
            if ( $save_succesful ) {

                    /**
                     * @var object
                     * Holds (retrieves again) all the information about a specific request
                     * Information can be accessed by $information_request->[name-of-the-attribute-in-db-table]
                    */
                    $information_request = $aanvragen_controle->getInformationSpecificRequest( $monsternummer );

            }

        }

    }

    /**
     * @var boolean
     * Keep track of current action
     * FALSE indicates there is currently NO action active
    */
    $action = FALSE;

    // Check the GET data
    if ( !empty( $get_array ) ) {

        // Check actions
        if ( isset( $get_array['action'] ) ) {

            /**
             * @var string
             * Holds the current action that is performed by the user
            */
            $action = $aanvragen_controle->handleGetAction( $get_array );

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
                    <h1 class="h1 mb-4">Aanvraag controle monsternummer: <?php echo $information_request->monsternummer; ?></h1>
                    <p class="mb-4">
                    Deze pagina geeft de ingevulde gegevens weer van monsternummer <?php echo $information_request->monsternummer; ?>.
                    </p> <!-- .mb-4 -->
                    <p class="mb-4 d-lg-none">
                    Houdt er rekening mee dat op mobiel deze gegevens niet bewerkt kunnen worden.
                    </p>
                    <form action="<?php echo $form_url; ?>" method="POST" class="needs-validation" novalidate>
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
                                <?php
                                    // If user is updating information, remove disabled attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                        <select name="status-aanvraag" id="status-aanvraag" required class="custom-select">
                                <?php 
                                    } else { 
                                ?>
                                    <select name="status-aanvraag" id="status-aanvraag" required disabled class="custom-select">
                                <?php 
                                    } 

                                    // Define the constants for the status
                                    define( 'SAMPLE_NOG_NIET_ONTVANGEN', 1 );
                                    define( 'IN_BEHANDELING', 2 );
                                    define( 'AFGEHANDELD', 3 );

                                    // If status is 'Sample nog niet ontvangen', show this option element first
                                    // Convert current value to integer
                                    if ( intval( $information_request->fk_wp_oliepor_status_id ) === SAMPLE_NOG_NIET_ONTVANGEN ) {
                                        ?>
                                        <option selected="selected" value="1">Sample nog niet ontvangen</option>
                                        <option value="2">In behandeling</option>
                                        <option value="3">Afgehandeld</option>
                                        <?php
                                    }
                                    
                                    // If status is 'In behandeling', show this option element first
                                    // Convert current value to integer
                                    if ( intval( $information_request->fk_wp_oliepor_status_id ) === IN_BEHANDELING ) {
                                        ?>
                                        <option value="1">Sample nog niet ontvangen</option>
                                        <option selected="selected" value="2">In behandeling</option>
                                        <option value="3">Afgehandeld</option>
                                        <?php
                                    }

                                    // If status is 'Afgehandeld', show this option element first
                                    // Convert current value to integer
                                    if ( intval( $information_request->fk_wp_oliepor_status_id ) === AFGEHANDELD ) {
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
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="klantnaam" class="col-sm-3 col-form-label">Klant</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                        ?>
                                        <input name="klantnaam" type="text" required class="form-control-plain-text w-100" id="klantnaam" placeholder="Vul hier uw naam in" value="<?php echo $information_request->naam_klant; ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <input name="klantnaam" type="text" required readonly class="form-control-plain-text w-100" id="klantnaam" placeholder="Vul hier uw naam in" value="<?php echo $information_request->naam_klant; ?>">
                                        <?php
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Naam niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="Schipnaam" class="col-sm-3 col-form-label">Schip</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="Schipnaam" type="text" required class="form-control-plain-text w-100" id="Schipnaam" placeholder="Vul hier de naam van uw schip in" value="<?php echo $information_request->naam_schip; ?>">
                                <?php 
                                    } else { 
                                ?>
                                    <input name="Schipnaam" type="text" required readonly class="form-control-plain-text w-100" id="Schipnaam" placeholder="Vul hier de naam van uw schip in" value="<?php echo $information_request->naam_schip; ?>">
                                <?php 
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Scheepsnaam niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="motor" class="col-sm-3 col-form-label">Motor</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="motor" type="text" required class="form-control-plain-text w-100" id="motor" placeholder="Vul hier uw motor in" value="<?php echo $information_request->motor; ?>">
                                <?php 
                                    } else {
                                ?>
                                    <input name="motor" type="text" required readonly class="form-control-plain-text w-100" id="motor" placeholder="Vul hier uw motor in" value="<?php echo $information_request->motor; ?>">
                                <?php
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Motor niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="type" class="col-sm-3 col-form-label">Type</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="type-motor" type="text" required class="form-control-plain-text w-100" id="type" placeholder="Vul hier het type in" value="<?php echo $information_request->type_motor; ?>">
                                <?php
                                    } else {
                                ?>
                                    <input name="type-motor" type="text" required readonly class="form-control-plain-text w-100" id="type" placeholder="Vul hier het type in" value="<?php echo $information_request->type_motor; ?>">
                                <?php 
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Type motor niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="serienummer" class="col-sm-3 col-form-label">Serienummer</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="serienummer" pattern="^[a-z0-9]+$" type="text" required class="form-control-plain-text w-100" id="serienummer" placeholder="Vul hier het serienummer in" value="<?php echo $information_request->serienummer; ?>">
                                    <?php 
                                    } else {
                                ?>
                                    <input name="serienummer" pattern="^[a-z0-9]+$" type="text" required readonly class="form-control-plain-text w-100" id="serienummer" placeholder="Vul hier het serienummer in" value="<?php echo $information_request->serienummer; ?>">
                                <?php 
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Serienummer niet ingevuld of voldoet niet aan eisen.<br>
                                    Serienummer mag <em>alleen</em> bestaan uit:
                                    <ul>
                                        <li>a-z (kleine letters)</li>
                                        <li>0 tot en met 9</li>
                                    </ul>
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="soort-onderzoek" class="col-sm-3 col-form-label">Soort onderzoek</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="soort-onderzoek" type="text" required class="form-control-plain-text w-100" id="soort-onderzoek" placeholder="Vul hier het soort onderzoek in" value="<?php echo $information_request->soort_onderzoek; ?>">
                                        <?php 
                                    } else {
                                ?>
                                    <input name="soort-onderzoek" type="text" required readonly class="form-control-plain-text w-100" id="soort-onderzoek" placeholder="Vul hier het soort onderzoek in" value="<?php echo $information_request->soort_onderzoek; ?>">
                                <?php 
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Soort onderzoek niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="monster-datum" class="col-sm-3 col-form-label">Monsterdatum</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="monster-datum" type="date" required class="form-control-plain-text w-100" id="monster-datum" placeholder="Vul hier de monsterdatum in" value="<?php echo $information_request->monster_datum; ?>">
                                <?php 
                                    } else {
                                ?>
                                    <input name="monster-datum" type="date" required readonly class="form-control-plain-text w-100" id="monster-datum" placeholder="Vul hier de monsterdatum in" value="<?php echo $information_request->monster_datum; ?>">
                                <?php 
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Monsterdatum niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="urenstand-motor" class="col-sm-3 col-form-label">Urenstand motor</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="urenstand-motor" type="number" required class="form-control-plain-text w-100" id="urenstand-motor" placeholder="Vul hier de urenstand in van de motor" value="<?php echo $information_request->urenstand_motor; ?>">
                                    <?php 
                                    } else {
                                ?>
                                    <input name="urenstand-motor" type="number" required readonly class="form-control-plain-text w-100" id="urenstand-motor" placeholder="Vul hier de urenstand in van de motor" value="<?php echo $information_request->urenstand_motor; ?>">
                                <?php 
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Urenstand motor niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="merk-olie" class="col-sm-3 col-form-label">Merk olie</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="merk-olie" type="text" required class="form-control-plain-text w-100" id="merk-olie" placeholder="Vul hier het merk in van de olie" value="<?php echo $information_request->merk_olie; ?>">
                                <?php
                                    } else {
                                ?>
                                <input name="merk-olie" type="text" required readonly class="form-control-plain-text w-100" id="merk-olie" placeholder="Vul hier het merk in van de olie" value="<?php echo $information_request->merk_olie; ?>">
                                <?php
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Merk olie niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="type-olie" class="col-sm-3 col-form-label">Type olie</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="type-olie" type="text" required class="form-control-plain-text w-100" id="type-olie" placeholder="Vul hier het type in van de olie" value="<?php echo $information_request->type_olie; ?>">
                                <?php
                                    } else {
                                ?>
                                    <input name="type-olie" type="text" required readonly class="form-control-plain-text w-100" id="type-olie" placeholder="Vul hier het type in van de olie" value="<?php echo $information_request->type_olie; ?>">
                                <?php
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Type olie niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="urengebruik-olie" class="col-sm-3 col-form-label">Urengebruik olie</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="urengebruik-olie" type="number" required class="form-control-plain-text w-100" id="urengebruik-olie" placeholder="Vul hier het urengebruik in van de olie" value="<?php echo $information_request->urengebruik_olie; ?>">
                                <?php
                                    } else {
                                ?>
                                    <input name="urengebruik-olie" type="number" required readonly class="form-control-plain-text w-100" id="urengebruik-olie" placeholder="Vul hier het urengebruik in van de olie" value="<?php echo $information_request->urengebruik_olie; ?>">
                                <?php 
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Urengebruik olie niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="olie-ververst" class="col-sm-3 col-form-label">Olie ververst</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php
                                    // If user is updating information, remove disabled attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                        <select name="olie-ververst" id="olie-ververst" required class="custom-select w-100">
                                            <?php 
                                    } else {
                                ?>
                                        <select name="olie-ververst" id="olie-ververst" required disabled class="custom-select w-100">
                                <?php
                                    }
                                    /**
                                     * Define the constants for the dropdown menu
                                     * JA equals 1, NEE equals 0
                                     * The corresponding numbers will be saved to the database
                                    */
                                    define('JA', 1);
                                    define('NEE', 0);

                                    // If user has selected 'Ja' when filling in the form, make the default value 'Ja'
                                    // Convert current value to integer
                                    if ( intval( $information_request->olie_ververst ) === JA ) {
                                        ?>
                                        <option selected="selected" value="<?php echo constant( "JA" ); ?>">Ja</option>
                                        <option value="<?php echo constant( "NEE" ); ?>">Nee</option>
                                        <?php
                                    }
                                    
                                    // If user has selected 'nee' when filling in the form, make the default value 'Nee'
                                    // Convert current value to integer
                                    if ( intval( $information_request->olie_ververst ) === NEE ) {
                                        ?>
                                        <option value="<?php echo constant( "JA" ); ?>">Ja</option>
                                        <option selected="selected" value="<?php echo constant( "NEE" ); ?>">Nee</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecteer ja of nee.
                                </div>  <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="filters-ververst" class="col-sm-3 col-form-label">Filters ververst</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php
                                    // If user is updating information, remove disabled attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <select name="filters-ververst" id="filters-ververst" required class="custom-select w-100">
                                <?php
                                    } else {
                                ?>
                                    <select name="filters-ververst" id="filters-ververst" required disabled class="custom-select w-100">
                                <?php
                                    }
                                    // If user has selected 'Ja' when filling in the form, make the default value 'Ja'
                                    // Convert current value to integer
                                    if ( intval( $information_request->filters_ververst ) === JA ) {
                                        ?>
                                        <option selected="selected" value="<?php echo constant( "JA" ); ?>">Ja</option>
                                        <option value="<?php echo constant( "NEE" ); ?>">Nee</option>
                                        <?php
                                    }
                                    
                                    // If user has selected 'nee' when filling in the form, make the default value 'Nee'
                                    // Convert current value to integer
                                    if ( intval( $information_request->filters_ververst ) === NEE ) {
                                        ?>
                                        <option value="<?php echo constant( "JA" ); ?>">Ja</option>
                                        <option selected="selected" value="<?php echo constant( "NEE" ); ?>">Nee</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecteer ja of nee.
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="koelmiddel-gebruikt" class="col-sm-3 col-form-label">Koelmiddel gebruikt</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php
                                    // If user is updating information, remove disabled attribute, otherwise field can ONLY be read
                                    // (otherwise user won't be able to update the form field)
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <select name="koelmiddel-gebruikt" id="koelmiddel-gebruikt" required class="custom-select w-100">
                                <?php
                                    } else {
                                ?>
                                    <select name="koelmiddel-gebruikt" id="koelmiddel-gebruikt" required disabled class="custom-select w-100">
                                <?php
                                    }
                                    // If user has selected 'Ja' when filling in the form, make the default value 'Ja'
                                    // Convert current value to integer
                                    if ( intval( $information_request->koelmiddel_gebruikt ) === JA ) {
                                        ?>
                                        <option selected="selected" value="<?php echo constant( "JA" ); ?>">Ja</option>
                                        <option value="<?php echo constant( "NEE" ); ?>">Nee</option>
                                        <?php
                                    }
                                    
                                    // If user has selected 'nee' when filling in the form, make the default value 'Nee'
                                    // Convert current value to integer
                                    if ( intval( $information_request->koelmiddel_gebruikt ) === NEE ) {
                                        ?>
                                        <option value="<?php echo constant( "JA" ); ?>">Ja</option>
                                        <option selected="selected" value="<?php echo constant( "NEE" ); ?>">Nee</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Selecteer ja of nee.
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3">
                            <label for="merk-koelmiddel" class="col-sm-3 col-form-label">Merk koelmiddel</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating merk-koelmiddel field, remove read-only attribute, otherwise field can ONLY be read
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                    <input name="merk-koelmiddel" type="text" required class="form-control-plain-text w-100" id="merk-koelmiddel" placeholder="Vul hier het merk van uw koelmiddel in" value="<?php echo $information_request->merk_koelmiddel; ?>">
                                <?php
                                    } else {
                                ?>
                                    <input name="merk-koelmiddel" type="text" required readonly class="form-control-plain-text w-100" id="merk-koelmiddel" placeholder="Vul hier het merk van uw koelmiddel in" value="<?php echo $information_request->merk_koelmiddel; ?>">
                                <?php
                                    }
                                ?>
                                <div class="invalid-feedback">
                                    Merk koelmiddel niet ingevuld!
                                </div> <!-- .invalid-feedback -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3 opmerkingen-group">
                            <label for="opmerking" class="col-sm-3 col-form-label">Opmerkingen</label>
                            <div class="col-sm-9 col-lg-9 col-xl-6">
                                <?php 
                                    // If user is updating information, remove read-only attribute, otherwise field can ONLY be read
                                    if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                ?>
                                        <textarea name="opmerking" class="form-control w-100" id="opmerkingen" rows="10"><?php } else { ?><textarea name="opmerking" readonly required class="form-control w-100" id="opmerkingen" rows="10"><?php }if ( !empty( $information_request->opmerking ) ) { echo $information_request->opmerking; } ?></textarea>
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                        <div class="form-group row mb-3 opmerkingen-group">
                            <div class="col-sm-9 col-lg-9">
                                <div class="d-none d-xl-block bewerken-container">
                                    <?php 
                                    // If user is updating the information, change button text from 'Bewerken' to 'Opslaan'
                                        if ( isset( $get_array['action'] ) && ( $get_array['action'] === 'update' ) ) {
                                        ?>
                                        <input type="submit" name="update" class="portal-button portal-button-small opslaan-button" value="Opslaan">
                                    <?php 
                                        } else { 
                                    ?>
                                        <a href="<?php echo $update_link; ?>" class="portal-button portal-button-small">Bewerken</a>
                                    <?php 
                                        } 
                                    ?>
                                </div> <!-- .bewerken-container -->
                            </div> <!-- .col-sm-9 -->
                        </div> <!-- .form-group -->
                    </form> <!-- needs-validation -->
                </div> <!-- .col-md-10 -->
            </div> <!-- .row -->
        </div> <!-- .container -->
    </div> <!-- .wrap -->

    <!-- Modal for verification of a status change -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="statusModalLabel">Ben je zeker?</h5>
            <button type="button" class="close annuleer-button" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>
                Weet u zeker dat u de status van deze aanvraag wilt wijzigen?<br>Indien u dit niet wilt, zal de oude status behouden blijven.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary annuleer-button" data-bs-dismiss="modal">Annuleer</button>
            <button type="button" id="button-opslaan-status" class="btn btn-primary opslaan-button">Ja</button>
        </div>
        </div>
    </div>
    </div>
    
    <?php

} else { 
    // If user is trying to gain access to this page WITHOUT a given monsternummer, redirect the user
    // back to the dashboard

    /**
     * @var array
     * Contains the parameters for the redirect url
    */
    $params = array( 'page' => 'oliemonster-portal-admin-dashboard ');

    /**
     * @var string
     * Holds the redirect url (links to dashboard)
    */
    $redirect_url = add_query_arg( $params, $base_url );

    ?>
    <script>
        // Redirect user back to dashboard
        window.location.replace("<?php echo $redirect_url; ?>");
    </script>
    
    <?php

}
?>
<script>

    // Get status-aanvraag dropdown menu node
    const STATUS_AANVRAAG = document.getElementById("status-aanvraag");

    // Save prior status to wait for verification
    let PRIOR_STATUS = STATUS_AANVRAAG.selectedIndex + 1;

    // Detect if status-aanvraag dropdown field value changes
    STATUS_AANVRAAG.addEventListener("change", function() {
        jQuery( function( $ ) {

            // Open the verification modal
            $("#statusModal").modal("toggle");
            
            // Selected status (after change)
            const SELECTED_STATUS = STATUS_AANVRAAG.selectedIndex + 1;
            
            // Get button opslaan status node
            const BUTTON_OPSLAAN_STATUS = document.getElementById("button-opslaan-status");

            // If user presses button to save new status, change the status of the dropdown menu
            // and close the modal
            BUTTON_OPSLAAN_STATUS.addEventListener("click", function() {

                STATUS_AANVRAAG.value = SELECTED_STATUS;

                PRIOR_STATUS = SELECTED_STATUS;
                
                // Hide the verification modal
                $("#statusModal").modal("hide");

            });

            // Get buttons to cancel status change
            let BUTTON_ANNULEER_STATUS = document.getElementsByClassName("annuleer-button");

            // Convert the Live HTMLCollection to an array so forEach can be used to add the event listener to it
            BUTTON_ANNULEER_STATUS = [...BUTTON_ANNULEER_STATUS];

            // Loop over both cancel buttons to add event listener to it
            BUTTON_ANNULEER_STATUS.forEach(function(button) {
                
                // If user does NOT want to change the status, revert it to the old status
                button.addEventListener("click", function() {

                    STATUS_AANVRAAG.value = PRIOR_STATUS;

                });

            });

        } );
    });

    // Before submitting the form, remove all disabled attributes from <select>
    // Otherwise values from <select> won't be submitted (saved to the database)
    jQuery( function( $ ) {
        $( 'form' ).bind( 'submit', function() {
            $(this).find( ':input' ).prop( 'disabled', false );
        } )
    } );

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