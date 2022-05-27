<!DOCTYPE html>
<html>
    <head>
        <title><?php echo get_the_title(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    </head>
    <body <?php body_class( 'no-margin-left-right font-family-arial' ); ?>>
