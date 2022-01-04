<div class="wrap">
    <?php 
    
    if ( current_user_can('administrator') ) {
        ?>
        <h1>Admin dashboard</h1>
        <?php
    } else {
        ?>
        <h1>Subscriber dashboard</h1>
        <?php      
    }

    ?>
</div>
<?php 

?>