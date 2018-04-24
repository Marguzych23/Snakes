<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 17.04.2018
 * Time: 20:41
 */

namespace services\impl;

use models\Game;
use models\Snake;
use services\GameService;

class GameServiceImpl implements GameService
{

    private $game;

    /**
     * GameServiceImpl constructor.
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }


    public function getStepForSmartSnake()
    {
        // TODO: Implement getStepForSmartSnake() method.
    }

    public function getProbableMovementForOpponentSnake()
    {
        // TODO: Implement getProbableMovementForOpponentSnake() method.
    }

    /**
     * @param Snake $snake
     * @return array Snakes
     */
    private function getStepedSnakesArray(Snake $snake)
    {
//        TODO
        return [];
    }

    /**
     * @param Snake $snake1
     * @param Snake $snake2
     * @return int
     */
    private function getDistanceBetweenFirstSnakeHeadAndSecondSnakeTail(Snake $snake1, Snake $snake2)
    {
        $x1 = $snake1->getHead()[0];
        $y1 = $snake1->getHead()[1];

        $x2 = $snake2->getHead()[0];
        $y2 = $snake2->getHead()[1];

        $distance = sqrt(($x1 - $x2) * ($x1 - $x2) + ($y1 - $y2) * ($y1 - $y2));

        return (int)$distance;
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param Game $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }
}


