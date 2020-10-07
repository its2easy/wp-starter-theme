<?php
// Output main menu with walker
?>
<?php
wp_nav_menu( array(
	'theme_location'  => 'primary',
	'container' => false,
	'menu_class' => 'main-menu',
	'depth' => 2,
	'walker' => new Main_Menu_Walker(),
) );
?>
