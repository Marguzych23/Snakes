<?php
/**
 * Created by PhpStorm.
 * User: Arslan
 * Date: 27.04.2018
 * Time: 20:15
 */

namespace services\impl;


use services\RequestResponseService;

class MovementControlService extends RequestResponseService
{

    private $endString = null;

    public function send_request($url, $params)
    {
        parent::send_request($url, $params);
        $response = parent::getResponse();
        $curl = parent::getCurl();

        $statusCode = curl_getinfo($curl)["http_code"];
        $response = json_decode($response, true);


        if ($statusCode == 200) {
        } elseif (isset($response["you"])) {
            $this->endString = "We " . $response["you"] . ":\n"
                . "our score: " . $response["your score"] . ",\n"
                . "enemy score: " . $response["enemy score"] . ".";
        } else {
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }
    }

    /**
     * @return null
     */
    public function getEndString()
    {
        return $this->endString;
    }
}