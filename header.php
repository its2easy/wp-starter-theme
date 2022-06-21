<?php
$favicon_folder_url = get_template_directory_uri() . '/assets/img/favicons/';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<?php wp_head(); ?>

	<?= carbon_get_theme_option( 'crb_head_script' ) ?>
	<?php //echo get_field( 'theme_head_script', 'option' ) ?>
</head>
<body <?php body_class() ?>>

<?php //echo get_field( 'theme_body_start_script', 'option' ) ?>
<?= carbon_get_theme_option( 'crb_body_start_script' ) ?>

    <div class="wrap">

	    <?php get_template_part( 'partials/header' ); ?>
