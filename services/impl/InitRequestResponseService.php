<?php
/**
 * Created by PhpStorm.
 * User: Arslan
 * Date: 24.04.2018
 * Time: 19:05
 */

namespace services\impl;


use models\Game;
use models\Snake;
use services\RequestResponseService;

class InitRequestResponseService implements RequestResponseService
{
    private $game;
    private $snake;

    /**
     * @param $url
     * @param int $param
     */
    public function send_request($url, $param=42)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_URL => $url,
           CURLOPT_PORT => true,
           CURLOPT_POSTFIELDS => array(
               'answer' => $param
           )
        ));

        $response = curl_exec($curl);

        if ($response) {
            $this->init($response);
        } else {
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }

    }

    /**
     * @param $response
     */
    public function init($response) {
        if (isset($response['battle_id']) && isset($response['snake_id'])) {
            $battle_id = $response['battle_id'];
            $snake_id = $response['snake_id'];

            $this->snake = new Snake($snake_id, null, null, null, false);
            $this->game = new Game($battle_id, null, $this->snake);
        }
    }
}