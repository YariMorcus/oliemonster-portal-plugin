<?php 
function ur_redirect_after_login( $redirect, $user ) {
    return 'wp-admin' ;
}

// Redirect user on login to wp-admin
add_filter( 'user_registration_login_redirect', 'ur_redirect_after_login', 10, 2 );
?>