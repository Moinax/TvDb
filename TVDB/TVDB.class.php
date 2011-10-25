<?php
	/**
	 * Base TVDB library class, provides universal functions and variables
	 *
	 * @package PHP::TVDB
	 * @author Ryan Doherty <ryan@ryandoherty.com>
	 **/
	 
    /**
     * Constants defined here outside of class because class constants can't be 
     * the result of any operation (concatenation)
     */
    define('PHPTVDB_URL', 'http://thetvdb.com/');
    define('PHPTVDB_API_URL', PHPTVDB_URL.'api/');
	 
	class TVDB {

		/**
		 * Base url for TheTVDB
		 *
		 * @var string
		 */
		
		CONST baseUrl = PHPTVDB_URL;
		
		/**
		 * Base url for api requests
		 */
		
		CONST apiUrl = PHPTVDB_API_URL;
		
		/**
		 * API key for thetvdb.com
		 *
		 * @var string
		 */
		
		CONST apiKey = PHPTVDB_API_KEY;
	
		/**
		 * Fetches data via curl and returns result
		 * 
		 * @access protected
		 * @param $url string The url to fetch data from
		 * @return string The data
		 **/
		protected function fetchData($url) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
			$response = curl_exec($ch);
			
			$httpCode = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
			$headerSize = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
            $data = substr( $response, $headerSize );
			curl_close($ch);
			
			if($httpCode != 200) {
			    return false;
			}
			
			return $data;
		}
		
		
		/**
		 * Fetches data from thetvdb.com api based on action
		 *
		 * @access protected
		 * @param $params An array containing parameters for the request to thetvdb.com
		 * @return string The data from thetvdb.com
		 **/
		protected function request($params) {
			
			switch($params['action']) {
				
				case 'show_by_id':
					$id = $params['id'];
					$url = self::baseUrl.'data/series/'.$id.'/';
					
					$data = self::fetchData($url);
					return $data;
				break;
				
				case 'get_episode':
					$season = $params['season'];
					$episode = $params['episode'];
					$showId = $params['show_id'];
					$url = self::apiUrl.self::apiKey.'/series/'.$showId.'/default/'.$season.'/'.$episode;

					$data = self::fetchData($url);
					return $data;
				break;
				
				case 'search_tv_shows':
					$showName = urlencode($params['show_name']);
					$url = self::apiUrl."/GetSeries.php?seriesname=$showName";

					$data = self::fetchData($url);
					return $data;
				break;
				
				default:
					return false;
				break;
			}
		}
		
		
		/**
		 * Removes indexes from an array if they are zero length after trimming
		 *
		 * @param array $array The array to remove empty indexes from
		 * @return array An array with all empty indexes removed
		 **/
		public function removeEmptyIndexes($array) {
			
			$length = count($array);
			
			for ($i=$length-1; $i >= 0; $i--) { 
				if(trim($array[$i]) == ''){
					unset($array[$i]);
				}
			}
			
			sort($array);
			return $array;
		}
	}
?>