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


    /**
     * @return null
     */
    public function getStepForSmartSnake()
    {
        $step = null;
        $steps = [];
        $snakes1 = $this->getSteppedSnakesArray($this->game->getEnemySnake());
        $snakes2 = $this->getSteppedSnakesArray($this->game->getAllySnake());
        foreach ($snakes1 as $snake) {
//            min($this->getDistanceBetweenFirstSnakeHeadAndSecondSnakeTail($snake, $snakes2));
        }
        // TODO: Implement getStepForSmartSnake() method.
        return $step;
    }

    public function getProbableMovementForOpponentSnake()
    {
        // TODO: Implement getProbableMovementForOpponentSnake() method.
    }

    /**
     * @param Snake $snake
     * @return array Snakes
     */
    private function getSteppedSnakesArray(Snake $snake)
    {
//        $snakeToDown = null;
//        $snakeToUp = null;
//        $snakeToRight = null;
//        $snakeToLeft = null;
////        TODO optimize code
//        $snakeHead = $snake->getHead();
//        $snakeTail = $snake->getTail();
//        if (!empty($snake->getBody())) {
//            $snakeTail = $snake->getBody()[0];
//        }
//
//        $x = $snakeHead[0] - $snakeTail[0];
//        $y = $snakeHead[1] - $snakeTail[1];
//
//        if ($x == 0) {
//            $snakeToRight = $this->getStepedSnake(Game::STEP_RIGHT, $snake);
//            $snakeToLeft = $this->getStepedSnake(Game::STEP_LEFT, $snake);
//        } else if ($x > 0) {
//            $snakeToRight = $this->getStepedSnake(Game::STEP_RIGHT, $snake);
//        } else {
//            $snakeToLeft = $this->getStepedSnake(Game::STEP_LEFT, $snake);
//        }
//
//        if ($y == 0) {
//            $snakeToUp = $this->getStepedSnake(Game::STEP_UP, $snake);
//            $snakeToDown = $this->getStepedSnake(Game::STEP_DOWN, $snake);
//        } else if ($y > 0) {
//            $snakeToUp = $this->getStepedSnake(Game::STEP_UP, $snake);
//        } else {
//            $snakeToDown = $this->getStepedSnake(Game::STEP_DOWN, $snake);
//        }


        $snakeToRight = $this->getSteppedSnake(Game::STEP_RIGHT, $snake);
        $snakeToLeft = $this->getSteppedSnake(Game::STEP_LEFT, $snake);
        $snakeToUp = $this->getSteppedSnake(Game::STEP_UP, $snake);
        $snakeToDown = $this->getSteppedSnake(Game::STEP_DOWN, $snake);

        if (!$this->checkSnake($snakeToLeft)) {
            $snakeToLeft = null;
        }
        if (!$this->checkSnake($snakeToRight)) {
            $snakeToRight = null;
        }
        if (!$this->checkSnake($snakeToDown)) {
            $snakeToDown = null;
        }
        if (!$this->checkSnake($snakeToUp)) {
            $snakeToUp = null;
        }

        return array(
            Game::STEP_DOWN => $snakeToDown,
            Game::STEP_UP => $snakeToUp,
            Game::STEP_RIGHT => $snakeToRight,
            Game::STEP_LEFT => $snakeToLeft
        );
    }

    /**
     * @param string $step
     * @param Snake $snake
     * @return Snake
     */
    private function getSteppedSnake($step, Snake $snake)
    {
        $head = $snake->getHead();
        $body = null;
        $tail = null;

        $snakeBody = $snake->getBody();
        if (!empty($snakeBody)) {
            $body = [];
            array_push($body, $head);
            for ($i = 0; $i < count($snakeBody) - 1; $i++) {
                array_push($body, $snakeBody[$i]);
            }
            $tail = $snakeBody[count($snakeBody) - 1];
        } else {
            $tail = $head;
        }

        switch ($step) {
            case Game::STEP_DOWN:
                {
                    $head[1]--;
                    break;
                }
            case Game::STEP_UP:
                {
                    $head[1]++;
                    break;
                }
            case Game::STEP_RIGHT:
                {
                    $head[0]++;
                    break;
                }
            case Game::STEP_LEFT:
                {
                    $head[0]--;
                    break;
                }
            default:
        }

        return new Snake($head, $body, $tail, $snake->getIsBitten());
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

    private function checkSnake(Snake $snake)
    {
        $head = $snake->getHead();
        if (!empty($snake->getBody())) {
            foreach ($snake->getBody() as $item) {
                if ($item[0] == $head[0] and $item[1] == $head[1]) {
                    return false;
                }
            }
        }

        if ($snake->getTail()[0] == $head[0] and $snake->getTail()[1] == $head[1]) {
            return false;
        }

        return true;
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


