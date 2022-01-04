<div class="wrap">
    <?php 
    
    if ( current_user_can('administrator') ) {
        ?>
        <h1>Admin dashboard</h1>
        <?php
    } else {
        echo plugin_dir_path(__FILE__);?><BR><BR><?php
        echo plugin_dir_url(__DIR__);
        ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <img src="<?php echo plugin_dir_url( __DIR__ ); ?>/assets/img/logo-oliemonster.jpg" alt="" class="img-fluid d-block mx-auto" width="83" height="79">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Dashboard</h1>
                    <p>
                    Dit is het dashboard van het 'Oliemonster portal'. Deze pagina toont niet alleen het overzicht van uw ingediende aanvragen, voor het controleren van de oliemonsters, maar ook een button waarmee u een controle kunt aanvragen.
                    </p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">   
                <div class="col">
                    <h2>Snelle navigatie</h2>
                    <button class="btn portal-button">Aanvragen controle</button>
                </div>
            </div>
        </div>
        
        <?php      
    }

    ?>
</div>
<?php 

?>