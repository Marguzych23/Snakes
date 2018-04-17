<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 17.04.2018
 * Time: 20:41
 */

include_once "../models/Snake.php";

class SnakeService
{

    private $enemySnake;
    private $allySnake;

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


