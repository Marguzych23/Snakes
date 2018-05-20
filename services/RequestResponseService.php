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
            CURLOPT_POSTFIELDS => array(
                $params,
            )
        ));

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