<?php
include __DIR__.'/settings.php';
include __DIR__.'/src/PhpTvDb/TvDb/Tvdb.php';
include __DIR__.'/src/PhpTvDb/TvDb/Show.php';
include __DIR__.'/src/PhpTvDb/TvDb/Episode.php';

use \PhpTvDb\TvDb\Tvdb;

$tvdb = new Tvdb(PHPTVDB_URL, PHPTVDB_API_KEY);

$mirrors = $tvdb->getMirrors();
$languages = $tvdb->getLanguages();
$shows = $tvdb->search('Walking Dead');
$episodes = $tvdb->getEpisodes($shows->Series->id, 'fr');
echo count($episodes);