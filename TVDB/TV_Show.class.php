<?php
	/**
	 * Base class for interacting with TV shows
	 *
	 * @package PHP::TVDB
	 * @author Ryan Doherty <ryan@ryandoherty.com>
	 */

	class TV_Show extends TVDB {
		
		/**
		 * thetvdb.com show id
		 * 
		 * @access public
		 * @var integer|string
		 */
		public $id;
		
		/**
		 * Name of the TV show
		 * 
		 * @access public
		 * @var string
		 */
		public $seriesName;
		
		/**
		 * Current status of the TV Show. Values are 'Ended', 'Continuing' (other unknown values possible)
		 * 
		 * @access public
		 * @var string 
		 */
		public $status;
		
		/**
		 * First air date
		 * 
		 * @access public
		 * @var int Time in seconds since the epoc
		 */
		public $firstAired;
		
		/**
		 * TV Network the show is on
		 * 
		 * @access public
		 * @var string
		 */
		public $network;
		
		/**
		 * TV show runtime. Various formats (60 minutes, 30 mins)
		 * 
		 * @access public
		 * @var string
		 */
		public $runtime;
		
		/**
		 * Array of genres the tv show is (strings)
		 * 
		 * @access public
		 * @var array contains array of genres (strings)
		 */
		public $genres;
		
		/**
		 * Array of actor names
		 * 
		 * @access public
		 * @var array contains array of actors (strings)
		 */
		public $actors;
		
		/**
		 * Overview of the TV Show
		 * 
		 * @access public
		 * @var string 
		 */
		public $overview;
		
		/**
		 * Day of the week the TV show airs (Sunday, Monday, ...)
		 * 
		 * @access public
		 * @var string
		 */
		public $dayOfWeek;
		
		/**
		 * Time the tv show airs
		 * 
		 * @access public
		 * @var string
		 */
		public $airTime;
		
		/**
		 * Rating of the tv show
		 * 
		 * @access public
		 * @var string
		 */
		public $rating;
		
		/**
		 * IMDB's id for the tv show (http://imdb.com/title/$imdbId)
		 * 
		 * @access public
		 * @var string
		 */
		public $imdbId;
		
		/**
		 * Zap2It's id for the tv show (not sure how it is used yet)
		 *
		 * @access public
		 * @var string
		 */
		public $zap2ItId;
		
		
		/**
		 * Constructor
		 *
		 * @access public
		 * @param SimpleXMLObject $config A simplexmlobject created from thetvdb.com's xml data for the tv show
		 * @return void
		 **/
		function __construct($config) {
			
			$this->id = (string)$config->id;
			$this->seriesName = (string)$config->SeriesName;
			$this->status = (string)$config->Status;
			$this->firstAired = strtotime((string)$config->FirstAired);
			$this->network = (string)$config->Network;
			$this->runtime = (string)$config->Runtime;
			$this->genres = $this->removeEmptyIndexes(explode('|', (string)$config->Genre));
			$this->actors = $this->removeEmptyIndexes(explode('|', (string)$config->Actors));
			$this->overview = (string)$config->Overview;
			$this->dayOfWeek = (string)$config->Airs_DayOfWeek;
			$this->airTime = (string)$config->Airs_Time;
			$this->rating = (string)$config->Rating;
			$this->imdbId = (string)$config->IMDB_ID;
			$this->zap2ItId = (string)$config->zap2it_id;
		}
		
		
		/**
		 * Get a specific episode by season and episode number
		 *
		 * @var int $season required the season number
		 * @var int $episode required the episode number
		 * @return TV_Episode 
		 **/
		public function getEpisode($season, $episode) {
			$params = array('action' => 'get_episode', 
							'season' => (int)$season, 
							'episode' => (int)$episode,
							'show_id' => $this->id);
			
			$data = self::request($params);
			
			if ($data) {
				$xml = simplexml_load_string($data);
				return new TV_Episode($xml->Episode);
			} else {
				return false;
			}
		}
	}
?>