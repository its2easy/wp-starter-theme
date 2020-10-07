<?php
/**
 * Functions which used in theme
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );

// Removes tag class from the body_class array to avoid Bootstrap markup styling issues.
add_filter( 'body_class', 'theme_adjust_body_class' );
function theme_adjust_body_class( $classes ) {
	foreach ( $classes as $key => $value ) {
		if ( 'tag' === $value ) {
			unset( $classes[ $key ] );
		}
	}
	return $classes;
}

/**
 * Gets full image url
 *
 * @param string $name Path relative to theme/img folder
 * @return string Full url of the image
 */
function get_img( $name ){
	return get_template_directory_uri()."/assets/img/" . $name;
}

/**
 * Gets array with menu items
 *
 * @param string $location_name - registered location in theme setup
 * @return array|false Flat array of menu items
 */
function get_menu_items_by_location( $location_name ){
	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object( $locations[ $location_name ] ); // menu object
	return wp_get_nav_menu_items( $menu ); // menu elements
}

/**
 * Returns menu name set in admin settings
 *
 * @param string $location_name - registered location in theme setup
 *
 * @return string
 *
 */
function get_menu_name_by_location($location_name){
	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object( $locations[ $location_name ] );
	return $menu->name;
}

/**
 * Gets the appropriate word variant based on the number
 *
 * @param int $number Count
 * @param array $endingArray Array with 3 word forms
 * @param null|string $lang 2-letters language code (default ru)

 * @return string
 */
function getNumEnding($number, $endingArray, $lang = null)
{
	// RU branch
	if (!$lang || $lang == 'ru'){
		$number = $number % 100;

		if ($number>=11 && $number<=19) {
			$ending=$endingArray[2];
		}
		else {
			$i = $number % 10;
			switch ($i)
			{
				case (1): $ending = $endingArray[0]; break;
				case (2):
				case (3):
				case (4): $ending = $endingArray[1]; break;
				default: $ending=$endingArray[2];
			}
		}
		return $ending;
	}
	//ENG branch
	if ($lang && $lang == 'en'){
		if ($number == 1) {
			return $endingArray[0];
		} else {
			return $endingArray[1];
		}
	}

}

/**
 * Wrapper for getting carbon field
 *
 * @param int $id Post ID
 * @param string $name Carbon field name
 * @param null|string $placeholder Placeholder
 * @return null|string Return carbon field value or placeholder if empty
 */
function theme_carbon_get_post_meta($id, $name, $placeholder = null){
	$field = carbon_get_post_meta($id, $name);
	if (!$field && $placeholder) $field = $placeholder;
	if (!$field) $field = '';
	return $field;
}

/**
 * Returns a cleaned phone number to use in href="tel:"
 *
 * @param string $phone full phone number
 *
 * @return string
 */
function get_tel_link($phone){
	return str_replace(array('-',' ', '(', ')' ), '', $phone);
}

/**
 * Returns full image path by ID
 *
 * @param int $id
 * @param string $size
 *
 * @return string
 */
function get_img_url_by_id($id, $size = "full"){
	return wp_get_attachment_image_src( $id, 'full')[0];
}

/**
 * Custom excerpt with limit end separator
 *
 * @param int|null $limit
 * @param string|null $separator
 * @return string
 */
function theme_get_the_excerpt($limit = null, $separator = null) {
	if (has_excerpt()) return get_the_excerpt();

	// Set standard words limit
	if (is_null($limit)){
		$excerpt = explode(' ', get_the_excerpt(), '15');
	} else {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
	}

	// Set standard separator
	if (is_null($separator)){
		$separator = '...';
	}
	if (has_excerpt()) $separator = '';

	// Excerpt Generator
	if (count($excerpt) >= $limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).$separator;
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}


/**
 * Returns filesize in human format and translated
 *
 * @param string $filepath full system path
 *
 * @return bool|false|string
 */
function theme_get_filesize($filepath){
	$bytes = filesize($filepath);
	//$s = array('b', 'Kb', 'Mb', 'Gb');
	//$e = floor(log($bytes)/log(1024));
	//return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
	return size_format($bytes, 2);
}

/**
 * Check if plugin is active
 *
 * <code>
 * <?php theme_is_plugin_active('plugin-name/plugin-main-file.php') ?>
 * </code>
 *
 * @param string $plugin plugin main file relative path
 *
 * @return bool
 *
 */
function theme_is_plugin_active($plugin){
	return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}


/**
 * Returns items separated with commas
 *
 * @param array|string $arr
 *
 * @return string
 */
function theme_get_array_output_list($arr){
	if (!is_array($arr)) return $arr;
	$result = '';
	for($i=0; $i < count($arr); $i++)
	{
		$result .= trim( htmlspecialchars($arr[$i]));
		if ( $i != count($arr)-1 ) $result .= ", ";
	}
	return $result;
}

/**
 * Returns or outputs svg inline content
 *
 * @param string $name Name of file inside theme icons folder
 * @param null|bool $echo
 *
 * @return false|string
 */
function get_inline_svg($name, $echo = true){
	if (!$echo) ob_start();
	get_template_part( "partials/icons/$name" );//todo change to raw include
	if (!$echo) return ob_get_clean();

	return false;
}

/**
 * Outputs hidden fields with common form info
 */
function the_form_common_info(){
	$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
	       . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	?>
	<input type="hidden" name="url" value="<?= $url ?>">
	<input type="hidden" name="page" value="<?= wp_get_document_title() ?>">
<?php
}

if ( ! function_exists('d') ) {
	/**
     * Dump variable in readable format
     *
	 * @param mixed $var
	 */
    function d($var){
        echo "<pre>";
	    var_dump($var);
        echo "</pre>";
    }
}