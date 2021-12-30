<?php
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

/**
 * Check if 'edit' or 'new-post' screen of a
 * given post type is opened
 *
 * @param null $post_type name of post type to compare
 *
 * @return bool true or false
 */
function is_edit_or_new_cpt( $post_type = null ) {
	global $pagenow;

	/**
	 * return false if not on admin page or
	 * post type to compare is null
	 */
	if ( ! is_admin() || $post_type === null ) {
		return FALSE;
	}

	/**
	 * if edit screen of a post type is active
	 */
	if ( $pagenow === 'post.php' ) {
		// get post id, in case of view all cpt post id will be -1
		$post_id = isset( $_GET[ 'post' ] ) ? $_GET[ 'post' ] : - 1;

		// if no post id then return false
		if ( $post_id === - 1 ) {
			return FALSE;
		}

		// get post type from post id
		$get_post_type = get_post_type( $post_id );

		// if post type is compared return true else false
		if ( $post_type === $get_post_type ) {
			return TRUE;
		} else {
			return FALSE;
		}
	} elseif ( $pagenow === 'post-new.php' ) { // is new-post screen of a post type is active
		// get post type from $_GET array
		$get_post_type = isset( $_GET[ 'post_type' ] ) ? $_GET[ 'post_type' ] : '';
		// if post type matches return true else false.
		if ( $post_type === $get_post_type ) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else {
		// return false if on any other page.
		return FALSE;
	}
}

/**
 * Returns inline svg for image placeholder
 * @param int $width
 * @param int $height
 * @param string|null $color
 *
 * @return string
 */
function get_svg_placeholder($width = 1, $height = 1, $color = null){
	$color_string = ($color) ? "style='background: ". urlencode($color)."'" : '';
	return
		"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 $width $height' $color_string %3E%3C/svg%3E";
}

/**
 * Shorthand for carbon_get_post_meta from Carbon Fields
 *
 * @param string $key
 *
 * @return mixed
 */
function crb_postmeta($key){
	return carbon_get_post_meta( get_the_ID(), $key );
}

/**
 *  Dump and die, but die is optional
 *
 * @param mixed $var
 * @param null $die
 */
function dd($var, $die = null){
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
	if ($die){
		die;
	}
}
