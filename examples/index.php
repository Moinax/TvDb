<?php
include __DIR__ . '/settings.php';
include __DIR__.'../src/TvDb/Client.php';
include __DIR__.'../src/TvDb/Show.php';
include __DIR__.'../src/TvDb/Episode.php';

use TvDb\Client;

$tvdb = new Client(PHPTVDB_URL, PHPTVDB_API_KEY);

$mirrors = $tvdb->getMirrors();
$languages = $tvdb->getLanguages();
$shows = $tvdb->search('Walking Dead');
$episodes = $tvdb->getEpisodes($shows->Series->id, 'fr');
echo count($episodes);