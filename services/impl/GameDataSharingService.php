<?php
/**
 * Created by PhpStorm.
 * User: Arslan
 * Date: 24.04.2018
 * Time: 21:37
 */

namespace services\impl;


use models\Snake;
use services\RequestResponseService;

class GameDataSharingService extends RequestResponseService
{

    private $allySnake;
    private $enemySnake;

    public function send_request($url, $params)
    {
        $response = parent::getResponse();
        $curl = parent::getCurl();

        $response = json_decode($response, true);

        if ($response) {
            if ($response[0] == 202) {
                $this->send_request($url, $params);
            } else {
                $this->setAllData($response);
            }
        } else {
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }
    }

    public function setAllData($response) {
        $snakes = $response['snakes'];

        $enemySnake = $snakes['enemy'];
        $allySnake = $snakes['ally'];

        $this->allySnake = new Snake($allySnake['head'], $allySnake['body'], $allySnake['tail'],
            $allySnake['is_bited']);
        $this->enemySnake = new Snake($enemySnake['head'], $enemySnake['body'], $enemySnake['tail'],
            $enemySnake['is_bited']);

    }

    public function stepsLeft($response) {
        $battle = $response['battle'];

        return $battle['steps_left'];
    }

}