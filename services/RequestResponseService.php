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

    public function send_request($url, $params)
    {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));

        $response = curl_exec($this->curl);

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