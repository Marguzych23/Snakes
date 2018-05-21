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


class InitRequestResponseService extends RequestResponseService
{
    private static $game;
    private static $snake;

    /**
     * @param $url
     * @param int $param
     */
    public function send_request($url, $param)
    {
        parent::send_request($url, $param);
        $response = parent::getResponse();
        $curl = parent::getCurl();

        if ($response) {
            $this->init($response);
        } else {
            die(self::class.' Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }
    }

    /**
     * @param $response
     */
    public function init($response)
    {
        $response = json_decode($response, true);

        if (isset($response['battle_id']) && isset($response['snake_id'])) {
            $battle_id = $response['battle_id'];
            $snake_id = $response['snake_id'];

            self::$snake = new Snake(null, null, null, false);
            self::$game = new Game($battle_id, $snake_id, self::$snake, self::$snake);
        }
    }

    /**
     * @return mixed
     */
    public static function getGame()
    {
        return self::$game;
    }

    /**
     * @return mixed
     */
    public static function getSnake()
    {
        return self::$snake;
    }
}