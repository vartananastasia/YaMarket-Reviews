<?php

namespace YaMarket;

use GuzzleHttp\Client as GC;


/**
 * Class Client
 * @package YaMarket
 */
class Client
{
    private $key;
    private $id;

    # API settings
    const api_base_url = 'https://api.content.market.yandex.ru/';
    const API_VERSION = 'v2.1.0';


    /**
     * Client constructor.
     * @param $key
     * @param $id
     */
    public function __construct($key, $id)
    {
        $this->key = $key;
        $this->id = $id;
    }


    /**
     * sets url for reviews
     * @return string
     */
    private function api_url()
    {
        return self::api_base_url . self::API_VERSION . "/models/{$this->id}/opinions";
    }


    /**
     * @param int $page
     * @return string
     */
    private function url_params($page)
    {
        $fields = ['count' => 10, 'page' => $page, 'how' => 'DESC', 'sort' => 'DATE'];
        $params = '';
        foreach ($fields as $key => $field){
            $params .= $key . '=' . $field . '&';
        }
        return $params ? self::api_url() . '?' . substr($params, 0, -1) : self::api_url();
    }


    /**
     * @param int $page
     * @return mixed
     */
    public function get_reviews($page = 1)
    {
        $url = self::url_params($page);
        $client = new GC();
        $response = $client->request('GET', $url, ['headers' => ['Authorization' => $this->key]]);
        $data = current(self::JsonInAr($response->getBody()))->opinions;
        return $data;
    }


    /**
     * terns json returned from api in arr
     *
     * @param $json
     * @return mixed
     */
    public static function JsonInAr($json)
    {
        $data = json_decode($json);
        $error = json_last_error();

        if ($error == JSON_ERROR_NONE)
        {
            return [$data, True];
        }else{
            return [json_last_error_msg(), False];
        }
    }
}