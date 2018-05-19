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
        $response = json_decode($response, true);

        if ($response) {
            if (!$response[0] == 200) {
                if (isset($response["you"])) {
                    $this->endString = "We " . $response["you"] . ":\n"
                        . "our score: " . $response["your score"] . ",\n"
                        . "enemy score: " . $response["enemy score"] . ".";
                }
                $this->send_request($url, $params);
            }
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