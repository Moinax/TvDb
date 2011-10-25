<?php

	/**
	 * TV_Episode class. Class for single tv episode for a TV show.
	 *
	 * @package PHP::TVDB
	 * @author Ryan Doherty <ryan@ryandoherty.com>
	 **/
	class TV_Episode extends TVDB {
		
		/**
		 * The tvdb.com episode id
		 * 
		 * @access public
		 * @var integer
		 */
		public $id;
		
		/**
		 * The season number
		 * 
		 * @access public
		 * @var integer|string
		 */
		public $season;
		
		/**
		 * The episode number for the season
		 * 
		 * @access public
		 * @var integer|string
		 */
		public $number;
		
		/**
		 * The episode name
		 * 
		 * @access public
		 * @var string
		 */
		public $name;
		
		/**
		 * First air date of the episode measured in number of seconds from the epoch
		 * 
		 * @access public
		 * @var int
		 */
		public $firstAired;
		
		/**
		 * Array of guest star names (strings)
		 * 
		 * @access public
		 * @var array
		 */
		public $guestStars;
		
		/**
		 * Array of director names (strings)
		 * 
		 * @access public
		 * @var array
		 */
		public $directors;
		
		/**
		 * Array of writers names (strings)
		 * 
		 * @access public
		 * @var array
		 */
		public $writers;
		
		/**
		 * Overview of the episode
		 * 
		 * @access public
		 * @var string
		 */
		public $overview;
		
		/**
		 * IMDB id (http://imdb.com/title/$imdbId)
		 * 
		 * @access public
		 * @var string
		 */
		public $imdbId;
		
		/**
		 * Constructor
		 *
		 * @access public
		 * @return void
		 * @param simplexmlobject $config simplexmlobject created from thetvdb.com's xml data for the tv episode
		 **/
		function __construct($config) {
			

			
			$this->id = (string)$config->id;
			$this->season = (string)$config->SeasonNumber;
			$this->number = (string)$config->EpisodeNumber;
			$this->episode = (string)$config->EpisodeNumber;
			$this->firstAired = strtotime((string)$config->FirstAired);
			$this->guestStars = $this->removeEmptyIndexes(explode('|', (string)$config->GuestStars));
			$this->guestStars = array_map('trim', $this->guestStars);
			$this->directors = $this->removeEmptyIndexes(explode('|', (string)$config->Director));
			$this->writers = $this->removeEmptyIndexes(explode('|', (string)$config->Writer));
			$this->overview = (string)$config->Overview;
			$this->imdbId = (string)$config->IMDB_ID;
			$this->name = (string)$config->EpisodeName;	
		}
	}
?>