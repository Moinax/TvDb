<?php

namespace PhpTvDb\TvDb;

/**
 * Base TVDB library class, provides universal functions and variables
 *
 * @package PhpTvDb
 * @author Ryan Doherty <ryan@ryandoherty.com>
 * @author Jérôme Poskin <moinax@gmail.com>
 **/
class Tvdb
{

    /**
     * Base url for TheTVDB
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * API key for thetvdb.com
     *
     * @var string
     */
    protected $apiKey;

    public function __construct($baseUrl, $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Searches for tv shows based on show name
     *
     * @var string $showName the show name to search for
     * @access public
     * @return array An array of TV_Show objects matching the show name
     **/
    public function search($showName)
    {
        $params = array('action' => 'search_tv_shows', 'show_name' => $showName);
        $data = $this->request($params);

        if ($data) {
            $xml = simplexml_load_string($data);
            $shows = array();
            foreach ($xml->Series as $show) {
                $shows[] = $this->getShow($show->seriesid);
            }

            return $shows;
        }
    }

    /**
     * Find a tv show by the id from thetvdb.com
     *
     * @return TV_Show|false A TV_Show object or false if not found
     **/
    public function getShow($showId)
    {
        $params = array('action' => 'show_by_id', 'id' => $showId);
        $data = $this->request($params);

        if ($data) {
            $xml = simplexml_load_string($data);
            $show = new Show($xml->Series);
            return $show;
        } else {
            return false;
        }
    }

    /**
     * Get a specific episode by season and episode number
     *
     * @var int $season required the season number
     * @var int $episode required the episode number
     * @return TV_Episode
     **/
    public function getEpisode($season, $episode)
    {
        $params = array('action' => 'get_episode',
                        'season' => (int)$season,
                        'episode' => (int)$episode,
                        'show_id' => $this->id);

        $data = $this->request($params);

        if ($data) {
            $xml = simplexml_load_string($data);
            return new Episode($xml->Episode);
        } else {
            return false;
        }
    }

    /**
     * Fetches data via curl and returns result
     *
     * @access protected
     * @param $url string The url to fetch data from
     * @return string The data
     **/
    protected function fetchData($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $data = substr($response, $headerSize);
        curl_close($ch);

        if ($httpCode != 200) {
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
    protected function request($params)
    {

        switch ($params['action']) {

            case 'show_by_id':
                $id = $params['id'];
                $url = $this->baseUrl . 'data/series/' . $id . '/';

                $data = $this->fetchData($url);
                return $data;
                break;

            case 'get_episode':
                $season = $params['season'];
                $episode = $params['episode'];
                $showId = $params['show_id'];
                $url = $this->baseUrl . 'api/' . $this->apiKey . '/series/' . $showId . '/default/' . $season . '/' . $episode;

                $data = $this->fetchData($url);
                return $data;
                break;

            case 'search_tv_shows':
                $showName = urlencode($params['show_name']);
                $url = $this->baseUrl . "api/GetSeries.php?seriesname=$showName";

                $data = $this->fetchData($url);
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
    public static function removeEmptyIndexes($array)
    {

        $length = count($array);

        for ($i = $length - 1; $i >= 0; $i--) {
            if (trim($array[$i]) == '') {
                unset($array[$i]);
            }
        }

        sort($array);
        return $array;
    }
}