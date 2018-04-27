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
    private $battle_id;
    private $snake_id;
    private $enemySnake;
    private $allySnake;

    const MAP_CELLS_COUNT = 50;

    const STEP_DOWN = "down";
    const STEP_UP = "up";
    const STEP_LEFT = "left";
    const STEP_RIGHT = "right";

    /**
     * Game constructor.
     * @param $battle_id
     * @param $snake_id
     * @param Snake $enemySnake
     * @param Snake $allySnake
     */
    public function __construct($battle_id, $snake_id, Snake $enemySnake, Snake $allySnake)
    {
        $this->battle_id = $battle_id;
        $this->snake_id = $snake_id;
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
        return $this->battle_id;
    }

    /**
     * @param int $battle_id
     */
    public function setBattleId($battle_id)
    {
        $this->battle_id = $battle_id;
    }

    /**
     * @return mixed
     */
    public function getSnakeId()
    {
        return $this->snake_id;
    }

    /**
     * @param mixed $snake_id
     */
    public function setSnakeId($snake_id): void
    {
        $this->snake_id = $snake_id;
    }
}