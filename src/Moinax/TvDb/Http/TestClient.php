<?php
namespace Moinax\TvDb\Http;

use Moinax\TvDb\Exception;

class TestClient implements HttpClient
{
  private $data = array();

  public function setData($url, $data) {
    $this->data[$url] = $data;
  }

  public function fetch($url, array $params = array(), $method = self::GET) {
    if (array_key_exists($url, $this->data)) {
      return $this->data[$url];
    }
    throw new Exception("no data configured for $url");
  }
}