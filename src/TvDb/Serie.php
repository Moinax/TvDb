<?php

namespace TvDb;

/**
 * Simple serie object
 *
 * @package TvDb
 * @author Jérôme Poskin <moinax@gmail.com>
 */
class Serie
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $banner;

    /**
     * @var string
     */
    public $overview;

    /**
     * @var DateTime
     */
    public $firstAired;

    /**
     * @var string
     */
    public $imdbId;

    /**
     * Constructor
     *
     * @access public
     * @param SimpleXMLObject $data A simplexmlobject created from thetvdb.com's xml data for the tv show
     * @return void
     **/
    public function __construct($data)
    {
        $this->id = (int)$data->id;
        $this->language = (string)$data->language;
        $this->name = (string)$data->SeriesName;
        $this->banner = (string)$data->banner;
        $this->overview = (string)$data->Overview;
        $this->firstAired = new \DateTime((string)$data->FirstAired);
        $this->imdbId = (string)$data->IMDB_ID;
    }
}