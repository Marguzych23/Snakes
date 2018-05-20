<?php
/**
 * Created by PhpStorm.
 * User: Arslan
 * Date: 24.04.2018
 * Time: 18:21
 */

namespace services;


abstract class RequestResponseService
{
    private $curl;
    private $response;

    public function send_request($url, $params) {
        $this->curl = curl_init();

        curl_setopt_array($this->curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params
        ));


        $response = curl_exec($this->curl);
        print_r($response);

        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getCurl()
    {
        return $this->curl;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
}