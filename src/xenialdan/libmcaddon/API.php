<?php

namespace xenialdan\libmcaddon;

/**
 * Class API
 * @package xenialdan\libmcaddon
 */
class API{

	/**
	 * @param $array
	 * @param $key
	 * @param $value
	 * @return array
	 */
	public static function search($array, $key, $value){
		$results = array();
		self::search_r($array, $key, $value, $results);
		return $results;
	}

	/**
	 * @param $array
	 * @param $key
	 * @param $value
	 * @param $results
	 */
	public static function search_r($array, $key, $value, &$results){
		if (!is_array($array)){
			return;
		}

		if (isset($array[$key]) && $array[$key] == $value){
			$results[] = $array;
		}

		foreach ($array as $subarray){
			self::search_r($subarray, $key, $value, $results);
		}
	}

	/**
	 * @param $json
	 * @param bool $assoc
	 * @param int $depth
	 * @param int $options
	 * @return mixed
	 */
	public static function json_clean_decode($json, $assoc = false, $depth = 512, $options = 0){
		// search and remove comments like /* */ and //
		$json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
		if (version_compare(phpversion(), '5.4.0', '>=')){
			return json_decode($json, $assoc, $depth, $options);
		} elseif (version_compare(phpversion(), '5.3.0', '>=')){
			return json_decode($json, $assoc, $depth);
		} else{
			return json_decode($json, $assoc);
		}
	}
}