TvDb
====

Based on the well known php library phptvdb (available on http://code.google.com/p/phptvdb/), this version
has been completely refactored to offer more features from the tvdb api (available on http://www.thetvdb.com/wiki/index.php/Programmers_API)
by using PHP 5.3 namespaces, very useful to import in a bigger project like Symfony 2 for example.

What does it do:
----------------

The Client implements almost all api functions from thetvdb excepted the download in ZIP format

Examples:
---------

Use the index.php to test the Api
Rename the settings.php.dist in settings.php if you wan to test and enter your own API key provided by http://thetvdb.com

Status:
-------
This version is quite stable and used in production on http://nextepisode.tv