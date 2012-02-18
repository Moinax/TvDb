<?php

namespace TvDb;

/**
 * Simple serie object
 *
 * @package TvDb
 * @author Jérôme Poskin <moinax@gmail.com>
 */
class FullSerie extends Serie
{
    /**
     * @var array
     */
    public $actors = array();

    /**
     * @var string
     */
    public $airsDayOfWeek = '';

    /**
     * @var string
     */
    public $airsTime = '';

    /**
     * @var string
     */
    public $contentRating = '';

    /**
     * @var array
     */
    public $genres = array();

    /**
     * @var string
     */
    public $network = '';

    /**
     * @var string
     */
    public $rating = '';

    /**
     * @var int
     */
    public $ratingCount = 0;

    /**
     * @var int
     */
    public $runtime = 0;

    /**
     * @var string
     */
    public $status = '';

    /**
     * @var DateTime
     */
    public $added;

    /**
     * @var int
     */
    public $addedBy;

    /**
     * @var string
     */
    public $fanArt = '';

    /**
     * @var DateTime
     */
    public $lastUpdated;

    /**
     * @var string
     */
    public $poster = '';

    /**
     * @var string
     */
    public $zap2ItId = '';
    /**
     * Constructor
     *
     * @access public
     * @param SimpleXMLObject $data A simplexmlobject created from thetvdb.com's xml data for the tv show
     * @return void
     **/
    public function __construct($data)
    {
        parent::__construct($data);

        $this->actors = Client::removeEmptyIndexes(explode('|', (string)$data->Actors));
        $this->airsDayOfWeek = (string)$data->Airs_DayOfWeek;
        $this->airsTime = (string)$data->Airs_Time;
        $this->contentRating = (string)$data->ContentRating;
        $this->genres = Client::removeEmptyIndexes(explode('|', (string)$data->Genre));
        $this->network = (string)$data->Network;
        $this->rating = (string)$data->Rating;
        $this->runtime = (int)$data->Runtime;
        $this->status = (string)$data->Status;
        $this->added = new \DateTime((string)$data->added);
        $this->addedBy = (int)$data->addedBy;
        $this->fanArt = (string)$data->fanart;
        $this->lastUpdated = new \DateTime((string)$data->lastupdated);
        $this->poster = (string)$data->poster;
        $this->zap2ItId = (string)$data->zap2it_id;

    }
}