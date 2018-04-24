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
    private $id;
    private $enemySnake;
    private $allySnake;

    const MAP_CELLS_COUNT = 50;

    /**
     * Game constructor.
     * @param int $id
     * @param Snake $enemySnake
     * @param Snake $allySnake
     */
    public function __construct($id, Snake $enemySnake, Snake $allySnake)
    {
        $this->id = $id;
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


}