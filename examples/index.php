<?php
include __DIR__ . '/settings.php';
include __DIR__.'/../src/TvDb/Client.php';
include __DIR__.'/../src/TvDb/Serie.php';
include __DIR__.'/../src/TvDb/Banner.php';
include __DIR__.'/../src/TvDb/Episode.php';

use TvDb\Client;

$tvdb = new Client(TVDB_URL, TVDB_API_KEY);

$serverTime = $tvdb->getServerTime();

$data = $tvdb->getSeries('Alcatraz');

$date = new \DateTime('-1 day');
$data = $tvdb->getUpdates($date->getTimestamp());
var_dump($data);
/*$languages = $tvdb->getLanguages();
$shows = $tvdb->search('Walking Dead');
$episodes = $tvdb->getEpisodes($shows->Series->id, 'fr');
echo count($episodes);*/