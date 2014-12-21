<?php

include __DIR__ . '/../src/Moinax/TvDb/TvDb.php';

use Moinax\TvDb\Client;
use Moinax\TvDb\Http\TestClient;

const TV_DB_URL     = 'http://thetvdb.com';
const TV_DB_API_KEY = 'someApiKey';

class TvDbTest extends PHPUnit_Framework_TestCase
{
  private $seriesId = 6667;
  /** @var  TestClient */
  private $testHttpClient;
  /** @var  Client */
  public $tvDb;

  public function setUp() {
    $this->testHttpClient = new TestClient();
    $this->injectHttpClientData();

    $this->tvDb = new Client(TV_DB_URL, TV_DB_API_KEY, $this->testHttpClient);
    $this->tvDb->getServerTime();
  }

  public function testGetSeries() {
    $data = $this->tvDb->getSeries('series name');

    $this->assertEquals(1, count($data));
    $this->assertEquals($this->seriesId, $data[0]->id);
    $this->assertEquals("The Series Name", $data[0]->name);
  }

  public function test_getEpisode() {
    $episode = $this->tvDb->getEpisode($this->seriesId, 1, 1, 'en');

    $this->assertEquals(7776, $episode->id);
    $this->assertEquals(1, $episode->number);
    $this->assertEquals(1, $episode->season);
    $this->assertEquals("Episode 1x01 title", $episode->name);
  }

  public function test_getSerieEpisodes() {
  }

  private function injectHttpClientData() {
    $this->testHttpClient->setData("http://thetvdb.com/api/".TV_DB_API_KEY."/mirrors.xml",
                                   "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>" .
                                   "<Mirrors>" .
                                   "<Mirror>" .
                                   "<id>1</id>" .
                                   "<mirrorpath>http://thetvdb.com</mirrorpath>" .
                                   "<typemask>7</typemask>" .
                                   "</Mirror>" .
                                   "</Mirrors>");

    $this->testHttpClient->setData("http://thetvdb.com/api/Updates.php?type=none",
                                   "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>" .
                                   "<Items>" .
                                   "<Time>1419193655</Time>" .
                                   "</Items>");

    $this->testHttpClient->setData("http://thetvdb.com/api/GetSeries.php?seriesname=series+name&language=en",
                                   "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>" .
                                   "<Data>" .
                                   "<Series>" .
                                   "<seriesid>6667</seriesid>" .
                                   "<language>en</language>" .
                                   "<SeriesName>The Series Name</SeriesName>" .
                                   "<banner>graphical/6667-g39.jpg</banner>" .
                                   "<Overview>overview</Overview>" .
                                   "<FirstAired>2010-10-31</FirstAired>" .
                                   "<Network>ABC</Network>" .
                                   "<IMDB_ID>123456</IMDB_ID>" .
                                   "<zap2it_id>89+56+</zap2it_id>" .
                                   "<id>6667</id>" .
                                   "</Series>" .
                                   "</Data>");

    $this->testHttpClient->setData("http://thetvdb.com/api/".TV_DB_API_KEY."/series/6667/default/1/1/en.xml",
                                   "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>" .
                                   "<Data><Episode>" .
                                   "<id>7776</id>" .
                                   "<seasonid>123</seasonid>" .
                                   "<EpisodeNumber>1</EpisodeNumber>" .
                                   "<EpisodeName>Episode 1x01 title</EpisodeName>" .
                                   "<FirstAired>2010-10-31</FirstAired>" .
                                   "<GuestStars></GuestStars>" .
                                   "<Director></Director>" .
                                   "<Writer></Writer>" .
                                   "<Overview></Overview>" .
                                   "<SeasonNumber>1</SeasonNumber>" .
                                   "<Language>en</Language>" .
                                   "</Episode></Data>");
  }
}