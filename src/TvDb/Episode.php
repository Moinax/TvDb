<?php

namespace TvDb;

/**
 * Episode class. Class for single tv episode for a TV serie.
 *
 * @package TvDb
 * @author Jérôme Poskin <moinax@gmail.com>
 **/
class Episode
{

    /**
     * @var int
     */
    public $id = 0;

    /**
     * @var int
     */
    public $number = 0;

    /**
     * @var int
     */
    public $season = 0;

    /**
     * @var array
     */
    public $directors = array();

    /**
     * @var array
     */
    public $guestStars = array();

    /**
     * @var array
     */
    public $writers = array();

    /**
     * @var string
     */
    public $name = '';

    /**
     * @var \DateTime
     */
    public $firstAired;

    /**
     * @var string
     */
    public $imdbId = '';

    /**
     * @var string
     */
    public $language = Client::DEFAULT_LANGUAGE;

    /**
     * @var string
     */
    public $overview = '';

    /**
     * @var string
     */
    public $rating = '';

    /**
     * @var int
     */
    public $ratingCount = 0;

    /**
     * @var DateTime
     */
    public $lastUpdated;

    /**
     * @var int
     */
    public $seasonId = 0;

    /**
     * @var int
     */
    public $serieId = 0;

    /**
     * @var string
     */
    public $thumbnail = '';

    /**
     * Constructor
     *
     * @access public
     * @return void
     * @param simplexmlobject $data simplexmlobject created from thetvdb.com's xml data for the tv episode
     **/
    public function __construct($data)
    {
        $this->id = (int)$data->id;
        if (isset($data->Combined_episodenumber)) {
            $this->number = (int)$data->Combined_episodenumber;
        } else {
            $this->number = (int)$data->EpisodeNumber;
        }
        if (isset($data->Comined_season)) {
            $this->season = (int)$data->Combined_season;
        } else {
            $this->season = (int)$data->SeasonNumber;
        }
        $this->directors = (array)Client::removeEmptyIndexes(explode('|', (string)$data->Director));
        $this->name = (string)$data->EpisodeName;
        $this->firstAired = (string)$data->FirstAired !== '' ? new \DateTime((string)$data->FirstAired) : null;
        $this->guestStars = Client::removeEmptyIndexes(explode('|', (string)$data->GuestStars));
        $this->imdbId = (string)$data->IMDB_ID;
        $this->language = (string)$data->Language;
        $this->overview = (string)$data->Overview;
        $this->rating = (string)$data->Rating;
        $this->ratingCount = (int)$data->RatingCount;
        $this->lastUpdated = \DateTime::createFromFormat('U', (int)$data->lastupdated);
        $this->writers = (array)Client::removeEmptyIndexes(explode('|', (string)$data->Writer));
        $this->thumbnail = (string)$data->filename;
        $this->seasonId = (int)$data->seasonid;
        $this->serieId = (int)$data->seriesid;
    }
}