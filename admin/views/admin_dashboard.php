<div class="wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-lg-3">
                    <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/assets/img/logo-oliemonster.jpg" alt="" class="img-fluid d-block mx-auto" width="140" height="79">
                </div>
                <div class="col-md-10 col-lg-7">
                    <h1 class="h1 mb-4">Admin Dashboard</h1>
                    <p class="mb-4">
                    Dit is het dashboard van het 'Oliemonster portal'. Deze pagina toont niet alleen het overzicht van uw ingediende aanvragen, voor het controleren van de oliemonsters, maar ook een button waarmee u een controle kunt aanvragen.
                    </p>
                    <section class="mb-4">
                        <h2 class="h2 mb-4">Snelle navigatie</h2>
                        <button class="btn portal-button">Aanvragen controle</button>
                    </section>
                    <section>
                        <h2 class="h2 mb-4">Overzicht ingediende aanvragen</h2>
                        <div class="table-responsive">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Monsternummer</th>
                                        <th scope="col">Soort onderzoek</th>
                                        <th scope="col">Status controle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1203232</td>
                                        <td>Brandstofvermenging</td>
                                        <td><span class="">Sample nog niet ontvangen</span></td>
                                    </tr>
                                    <tr>
                                        <td>2930572</td>
                                        <td>Brandpunt</td>
                                        <td><span class="">Afgehandeld</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <?php      
    ?>
</div>
<?php 

?>