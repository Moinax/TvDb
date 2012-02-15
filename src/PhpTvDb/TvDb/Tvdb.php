<?php

namespace PhpTvDb\TvDb;

/**
 * Base TVDB library class, provides universal functions and variables
 *
 * @package PhpTvDb
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

    /**
     * @param string $baseUrl Domain name of the api without trailing slash
     * @param string $apiKey Api key provided by http://thetvdb.com
     */
    public function __construct($baseUrl, $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Get a list of mirrors available to fetch the data from the api
     * @return SimpleXMLElement
     */
    public function getMirrors()
    {
        $url = $this->baseUrl . '/api/' . $this->apiKey . '/mirrors.xml';
        return $this->fetchData($url);
    }

    /**
     * Get a list of languages available for the content of the api
     * @return SimpleXMLElement
     */
    public function getLanguages()
    {
        $url = $this->baseUrl . '/api/' . $this->apiKey . '/languages.xml';
        return $this->fetchData($url);
    }

    /**
     * Searches for tv serie based on show name
     *
     * @var string $serieName the show name to search for
     * @return SimpleXMLElement
     **/
    public function search($serieName)
    {
        $url = $this->baseUrl . '/api/GetSeries.php?seriesname='. urlencode($serieName);

        return $this->fetchData($url);
    }

    /**
     * Find a tv show by the id from thetvdb.com
     *
     * @return Show|false A TV_Show object or false if not found
     **/
    public function getSerie($serieId)
    {
        $url = $this->baseUrl . '/data/series/' . $serieId . '/';
        $data = $this->fetchData($url);

        return new Show($data->Series);
    }

    public function getEpisodes($serieId, $language = 'en', $format = 'xml')
    {
        $url = $this->baseUrl . '/api/' . $this->apiKey . '/series/' . $serieId . '/all/' . $language . '.' . $format;
        return $this->fetchData($url);
    }

    /**
     * Get a specific episode by season and episode number
     *
     * @var int $serieId required the id of the serie
     * @var int $season required the season number
     * @var int $episode required the episode number
     * @return TV_Episode
     **/
    public function getEpisode($serieId, $season, $episode)
    {
        $url = $this->baseUrl . 'api/' . $this->apiKey . '/series/' . $serieId . '/default/' . $season . '/' . $episode;

        $data = $this->fetchData($url);

        return new Episode($data->Episode);
    }

    /**
     * Fetches data via curl and returns result
     *
     * @access protected
     * @param $url string The url to fetch data from
     * @return SimpleXMLElement The data
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

        return simplexml_load_string($data);
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