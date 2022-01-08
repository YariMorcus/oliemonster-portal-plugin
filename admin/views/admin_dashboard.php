<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3">
                <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/assets/img/logo-oliemonster.jpg" alt=""
                    class="img-fluid d-block mx-auto" width="140" height="79">
            </div> <!-- .col-md-2 -->
            <div class="col-md-10 col-lg-7">
                <h1 class="h1 mb-4">Dashboard</h1>
                <p class="mb-4">
                Dit is het dashboard van het project 'Het Oliemonster'.
                Deze pagina toont niet alleen het overzicht van de ingediende aanvragen, voor het controleren van de oliemonsters,
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
                                <tr>
                                    <td>1203232</td>
                                    <td>Yari Morcus</td>
                                    <td>Brandstofvermenging</td>
                                    <td><button class="portal-button portal-button-small">Bekijk aanvraag</button></td>
                                </tr>
                                <tr>
                                    <td>2930572</td>
                                    <td>John Doe</td>
                                    <td>Brandpunt</td>
                                    <td><button class="portal-button portal-button-small">Bekijk aanvraag</button></td>
                                </tr>
                            </tbody>
                        </table> <!-- .table -->
                    </div> <!-- .table-responsive -->
                </section>
            </div> <!-- .col-md-10 -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</div> <!-- .wrap -->