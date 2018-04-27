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

class GameDataSharingService implements RequestResponseService
{

    private $game;
    private $allySnake;
    private $enemySnake;

    public function send_request($url, $params)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_PORT => true,
            CURLOPT_POSTFIELDS => array(
                'snake_id' => $params[0],
                'battle_id' => $params[1]
            )
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        if ($response) {
            if ($response[0] == 202) {
                $this->send_request($url, $params);
            } else {
                $this->getData($response);
            }
        } else {
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }
    }

    public function getData($response) {
        $snakes = $response['snakes'];
        $battle = $response['battle'];

        $enemySnake = $snakes['enemy'];
        $allySnake = $snakes['ally'];

        $this->allySnake = new Snake(null, $allySnake['head'], $allySnake['body'], $allySnake['tail'], )

    }

}