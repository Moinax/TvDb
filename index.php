<?php

/**
 * Constants defined here outside of class because class constants can't be
 * the result of any operation (concatenation)
 */
define('PHPTVDB_URL', 'http://thetvdb.com/');
define('PHPTVDB_API_KEY', '16075636AB484A33');

include __DIR__.'/src/PhpTvDb/TvDb/Tvdb.php';
include __DIR__.'/src/PhpTvDb/TvDb/Show.php';
include __DIR__.'/src/PhpTvDb/TvDb/Episode.php';

use \PhpTvDb\TvDb\Tvdb;

$tvdb = new Tvdb(PHPTVDB_URL, PHPTVDB_API_KEY);

$shows = $tvdb->search('Walking Dead');

if (count($shows) > 0):?>
    <ul>
        <?php foreach($shows as $show): ?>
            <li><?php echo $show->seriesName; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No shows found</p>
<?php endif; ?>