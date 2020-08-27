TvDb
====

**Deprecated** This library was implemented to work with the TVDB API V1. 

It is now deprecated so I suggest you to find another library that implements the new API like https://github.com/adrenth/thetvdb2

[![Join the chat at https://gitter.im/Moinax/TvDb](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/Moinax/TvDb?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Based on the well known php library phptvdb (available on http://code.google.com/p/phptvdb/), this version
has been completely refactored to offer more features from the tvdb api (available on http://www.thetvdb.com/wiki/index.php/Programmers_API)
by using PHP 5.3 namespaces, very useful to import in a bigger project like Symfony 2 for example.

What does it do:
----------------

The Client implements almost all api functions from thetvdb excepted the download in ZIP format

Usage:
------

```php
use Moinax\TvDb\Client;
$apiKey = 'YOURAPIKEY';

$tvdb = new Client("https://thetvdb.com", $apiKey);
$tvdb->getSerie(75710);
```

Cache usage:
------------

To save bandwidth, reduce latency, or both of two, you can use a Http Client with caching features.
The HTTP client use the If-Modified-Since header to fetch full content only if resource was modified. This saves bandwidth.
The HTTP client also use a time to live parameter to completly avoid making request if resource was fresh enough. This reduce latency.

```php
<?php
use Moinax\TvDb\Http\Cache\FilesystemCache;
use Moinax\TvDb\Http\CacheClient;
use Moinax\TvDb\Client;

$ttl = 600; # how long things should get cached, in seconds.
$apiKey = 'YOURAPIKEY';

$cache = new FilesystemCache(__DIR__ . '/cache');
$httpClient = new CacheClient($cache, $ttl);

$tvdb = new Client("https://thetvdb.com", $apiKey);
$tvdb->setHttpClient($httpClient);

$tvdb->getSerie(75710); //This request will fetch the resource online.
$tvdb->getSerie(75710); //Cache content is fresh enough. We don't make any request.
sleep(600);
$tvdb->getSerie(75710); //The content is not fresh enough. We make a request with
                        //the If-Modified-Since header. The server respond 304 Not
                        //modified, so we load content from the cache.
```


Examples:
---------

Use the index.php to test the Api
Rename the settings.php.dist in settings.php if you wan to test and enter your own API key provided by http://thetvdb.com

Status:
-------
This version is quite stable and used in production on http://nextepisode.tv
