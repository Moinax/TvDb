<?php
namespace Moinax\TvDb\Http;

interface HttpClient
{
    public function fetch($url, array $params = array(), $method = self::GET);
}