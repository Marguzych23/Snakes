<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 23.04.2018
 * Time: 15:22
 */

namespace models;


class Game
{
    private $battleId;
    private $snakeId;
    private $enemySnake;
    private $allySnake;

    const MAP_CELLS_COUNT = 50;

    const STEP_DOWN = "down";
    const STEP_UP = "up";
    const STEP_LEFT = "left";
    const STEP_RIGHT = "right";

    /**
     * Game constructor.
     * @param $battleId
     * @param $snakeId
     * @param Snake $enemySnake
     * @param Snake $allySnake
     */
    public function __construct($battleId, $snakeId, Snake $enemySnake, Snake $allySnake)
    {
        $this->battleId = $battleId;
        $this->snakeId = $snakeId;
        $this->enemySnake = $enemySnake;
        $this->allySnake = $allySnake;
    }

    /**
     * @return Snake enemy
     */
    public function getEnemySnake()
    {
        return $this->enemySnake;
    }

    /**
     * @param Snake $enemySnake
     */
    public function setEnemySnake(Snake $enemySnake)
    {
        $this->enemySnake = $enemySnake;
    }

    /**
     * @return Snake ally
     */
    public function getAllySnake()
    {
        return $this->allySnake;
    }

    /**
     * @param Snake $allySnake
     */
    public function setAllySnake(Snake $allySnake)
    {
        $this->allySnake = $allySnake;
    }

    /**
     * @return int
     */
    public function getBattleId()
    {
        return $this->battleId;
    }

    /**
     * @param int $battleId
     */
    public function setBattleId(int $battleId)
    {
        $this->battleId = $battleId;
    }

    /**
     * @return int
     */
    public function getSnakeId()
    {
        return $this->snakeId;
    }

    /**
     * @param int $snakeId
     */
    public function setSnakeId(int $snakeId)
    {
        $this->snakeId = $snakeId;
    }
}