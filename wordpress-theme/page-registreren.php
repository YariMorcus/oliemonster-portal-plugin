<?php 
// Get WordPress header information
get_header();

?>

<header>
    <div class="logo-container">
        <img class="logo-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.jpg" width="155" height="148" alt="">
    </div>
    <div class="ga-terug">
        <a href="<?php echo get_site_url(); ?>/inloggen">Ga terug naar het login scherm</a>
    </div>
</header>

<?php

// Check if there are posts
if ( have_posts() ) :

    // If there are posts, loop over them
    while ( have_posts() ) :

        the_post();

        // Show the content
        the_content();

    endwhile;
else:
    // Show message in case there are no posts
    ?><p>Er is geen content aanwezig</p><?php

endif;

// Get WordPress footer information
get_footer(); 
?>
