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
     * @return null|string
     */
    public function getStepForSmartSnake()
    {
        $step = null;
        $steps = [];

        $allySnakes = $this->getSteppedSnakesArray($this->game->getEnemySnake());
        $enemySnakes = $this->getSteppedSnakesArray($this->game->getAllySnake());

        foreach ($allySnakes as $snake) {
            $emptyStep = $this->getProbableMovementForOpponentSnake($snake, $enemySnakes);
            if ($emptyStep) {
                array_push($steps, $emptyStep);
            }
        }

        $step = $this->getTheMostRepetitiveElement($steps);
        if (!$step) {
            $enemySnakeProbableStep = $this->getProbableMovementForOpponentSnake($this->game->getEnemySnake(), array($this->game->getAllySnake()));
            $step = $this->getProbableMovementForOpponentSnake($this->game->getAllySnake(), array($this->getSteppedSnake($enemySnakeProbableStep, $this->game->getEnemySnake())));
        }

        return $step;
    }

    /**
     * @param array $array
     * @return null|string
     */
    private function getTheMostRepetitiveElement(array &$array)
    {
        if (!empty($array)) {
            $arrayCountValues = array_count_values($array);
            if (arsort($arrayCountValues)) {
                return key($arrayCountValues);
            }
        }
        return null;
    }

    /**
     * @param Snake $snake
     * @param array $opponentSnakeSteppedArray
     * @return string $step
     */
    private function getProbableMovementForOpponentSnake(Snake $snake, array $opponentSnakeSteppedArray)
    {
        $step = "";
        $minDistance = Game::MAP_CELLS_COUNT;

        if (!empty($opponentSnakeSteppedArray)) {
            $step = $opponentSnakeSteppedArray[0][0];
            $minDistance = $this->getDistanceBetweenFirstSnakeHeadAndSecondSnakeTail($opponentSnakeSteppedArray[0][1], $snake);
            for ($i = 1; $i < count($opponentSnakeSteppedArray); $i++) {
                $distance = $this->getDistanceBetweenFirstSnakeHeadAndSecondSnakeTail($opponentSnakeSteppedArray[$i][1], $snake);
                if ($distance < $minDistance) {
                    $step = $opponentSnakeSteppedArray[0][0];
                }
            }
        }

        return $step;
    }

    /**
     * @param Snake $snake
     * @return array Snakes
     */
    private function getSteppedSnakesArray(Snake $snake)
    {
        $snakeToRight = $this->getSteppedSnake(Game::STEP_RIGHT, $snake);
        $snakeToLeft = $this->getSteppedSnake(Game::STEP_LEFT, $snake);
        $snakeToUp = $this->getSteppedSnake(Game::STEP_UP, $snake);
        $snakeToDown = $this->getSteppedSnake(Game::STEP_DOWN, $snake);

        $snakes = [];
        if (!$this->checkSnake($snakeToLeft)) {
            $snakeToLeft = null;
        } else {
            array_push($snakes, array(Game::STEP_LEFT, $snakeToLeft));
        }
        if (!$this->checkSnake($snakeToRight)) {
            $snakeToRight = null;
        } else {
            array_push($snakes, array(Game::STEP_RIGHT, $snakeToRight));
        }
        if (!$this->checkSnake($snakeToDown)) {
            $snakeToDown = null;
        } else {
            array_push($snakes, array(Game::STEP_DOWN, $snakeToDown));
        }
        if (!$this->checkSnake($snakeToUp)) {
            $snakeToUp = null;
        } else {
            array_push($snakes, array(Game::STEP_UP, $snakeToUp));
        }

        return $snakes;
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


