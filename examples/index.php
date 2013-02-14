<?php
include __DIR__ . '/settings.php';
include __DIR__.'/../src/TvDb/CurlException.php';
include __DIR__.'/../src/TvDb/Client.php';
include __DIR__.'/../src/TvDb/Serie.php';
include __DIR__.'/../src/TvDb/Banner.php';
include __DIR__.'/../src/TvDb/Episode.php';

use TvDb\Client;

$tvdb = new Client(TVDB_URL, TVDB_API_KEY);

$serverTime = $tvdb->getServerTime();
// Search for a show
$data = $tvdb->getSeries('Walking Dead');
// Use the first show found and get the S01E01 episode
$episode = $tvdb->getEpisode($data[0]->id, 1, 1, 'en');
var_dump($episode);

/*$date = new \DateTime('-1 day');
$data = $tvdb->getUpdates($date->getTimestamp());
var_dump($data);
*/

/*
$shows = $tvdb->search('Walking Dead');
$episodes = $tvdb->getEpisodes($shows->Series->id, 'fr');
echo count($episodes);*/