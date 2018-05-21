<?php
/**
 * Created by PhpStorm.
 * User: Arslan
 * Date: 24.04.2018
 * Time: 21:37
 */

namespace services\impl;


use models\Game;
use models\Snake;
use services\RequestResponseService;

class GameDataSharingService extends RequestResponseService
{

    private $endString = null;

    private $allySnake;
    private $enemySnake;
    private $game;

    public function send_request($url, $params)
    {
        parent::send_request($url, $params);
        $response = parent::getResponse();
        $curl = parent::getCurl();

        $statusCode = curl_getinfo($curl)["http_code"];
        $response = json_decode($response, true);

        if ($statusCode == 202) {
            $this->send_request($url, $params);
        } elseif (isset($response["battle"])) {
            $this->setAllData($response);
        } elseif (isset($response["you"])) {
            $this->endString = "We " . $response["you"] . ":\n"
                . "our score: " . $response["your score"] . ",\n"
                . "enemy score: " . $response["enemy score"] . ".";
        } else {
            print_r(curl_getinfo($curl));
            print_r($response);
            die(self::class.' Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }
    }

    public function setAllData($response)
    {
        $snakes = $response['snakes'];
        $enemySnake = $snakes['enemy'];
        $allySnake = $snakes['ally'];
        $this->allySnake = new Snake($allySnake['head'], $allySnake['body'], $allySnake['tail'],
            $allySnake['is_bited']);
        $this->enemySnake = new Snake($enemySnake['head'], $enemySnake['body'], $enemySnake['tail'],
            $enemySnake['is_bited']);

        $battle = $response["battle"];
        $battleId = $battle["battle_id"];
        $snakeId = $battle["snake_id"];
        $stepsLeft = $battle['steps_left'];

        $this->game = new Game($battleId, $snakeId, $this->enemySnake, $this->allySnake, $stepsLeft);
    }

    public function stepsLeft($response)
    {
        $battle = $response['battle'];

        return $battle['steps_left'];
    }

    /**
     * @return mixed
     */
    public function getAllySnake()
    {
        return $this->allySnake;
    }

    /**
     * @return mixed
     */
    public function getEnemySnake()
    {
        return $this->enemySnake;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }


    /**
     * @return null
     */
    public function getEndString()
    {
        return $this->endString;
    }
}