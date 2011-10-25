<?php
	/**
	 * Library that encapsulates thetvdb.com API for easy access to TV show information
	 *
	 * @author Ryan Doherty <ryan@ryandoherty.com>
	 * @version 1.0
	 * @copyright Ryan Doherty, 16 February, 2008
	 * @package PHP::TVDB
	 **/
	
	
	/**
	 * ADD YOUR API KEY HERE
	 */
	define('PHPTVDB_API_KEY', '');
	
	
	//Include our files and we're done!
	require 'TVDB/TVDB.class.php';
	require 'TVDB/TV_Show.class.php';
	require 'TVDB/TV_Shows.class.php';
	require 'TVDB/TV_Episode.class.php';
?>