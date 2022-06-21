<?php
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
 * Returns file extension from any file path
 * @param string $filepath
 *
 * @return string
 */
function theme_get_filename_ext($filepath){
	$tmp = explode('.', $filepath);
	return end($tmp);
}

/**
 * Return an array with webpack manifest data
 * @param $path string System path to build folder
 *
 * @return array|null
 */
function theme_get_webpack_manifest_data($path){
	if ( file_exists("$path/manifest.json") ) { // handle first run or no scripts
		$webpack_manifest = file_get_contents("$path/manifest.json");
		return json_decode($webpack_manifest, true);
	}
	else return array();
}
