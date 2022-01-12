<?php 

// Include the model
require_once OLIEMONSTER_PORTAL_PLUGIN_INCLUDES_MODEL_DIR . '/AanvragenControle.php';

// Declare class variable
$aanvragen_controle = new AanvragenControle();

// Set base url for this page
$base_url = get_admin_url() . 'admin.php';

?>

<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-2">
                <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/assets/img/logo-oliemonster.jpg" alt=""
                    class="img-fluid d-block mx-auto" width="140" height="79">
            </div> <!-- .col-md-2 -->
            <div class="col-md-10 col-lg-9">
                <h1 class="h1 mb-4">Dashboard</h1>
                <p class="mb-4">
                Dit is het dashboard van het project 'Het Oliemonster'.<br>
                Deze pagina toont niet alleen het overzicht van de ingediende aanvragen, voor het controleren van de oliemonsters,<br>
                maar ook een button waarmee u testresultaten kunt verwerken.
                </p> <!-- .mb-4 -->
                <section class="mb-4">
                    <h2 class="h2 mb-4">Snelle navigatie</h2>
                    <a href="#" class="btn portal-button portal-button-large">Verwerken testresultaten</a>
                </section> <!-- .mb-4 -->
                <section>
                    <h2 class="h2 mb-4">Overzicht ingediende aanvragen</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Monsternummer</th>
                                    <th scope="col">Klant</th>
                                    <th scope="col">Soort onderzoek</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    // Get all requested checks
                                    $check_list = $aanvragen_controle->getAllCheckRequests();

                                    // Loop over every check request and fill in the table
                                    foreach( $check_list as $check) {
                                        
                                    $params = array( 'page' => 'bekijken_gegevens', 'controle_id' => $check->controle_ID );
                                    $update_url = add_query_arg( $params, $base_url );
                                        ?>
                                        <tr>
                                            <td><?php echo $check->monsternummer; ?></td>
                                            <td><?php echo $check->naam_klant; ?></td>
                                            <td><?php echo $check->soort_onderzoek; ?></td>
                                            <td><a href="<?php echo $update_url; ?>" class="portal-button portal-button-small">Bekijk aanvraag</a></td>
                                        </tr>                                    
                                        <?php
                                    
                                    }
                                ?>
                                <!-- <tr>
                                    <td>2930572</td>
                                    <td>John Doe</td>
                                    <td>Brandpunt</td>
                                    <td><button class="portal-button portal-button-small">Bekijk aanvraag</button></td>
                                </tr> -->
                            </tbody>
                        </table> <!-- .table -->
                    </div> <!-- .table-responsive -->
                </section>
            </div> <!-- .col-md-10 -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</div> <!-- .wrap -->