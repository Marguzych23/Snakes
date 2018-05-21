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
     * Возвращает ход змеи союзника.
     *
     * @return null|string
     */
    public function getStepForAllySnake()
    {
        $step = null;
        $steps = [];

        $allySnakes = $this->getSteppedSnakesArray($this->game->getAllySnake());
        $enemySnakes = $this->getSteppedSnakesArray($this->game->getEnemySnake());

        /*
         * Вычисляются все возможные ходы змеи союзника против всех возможных ходов змеи соперника
         * и добавляются в массив ходов $steps.
         */
        foreach ($allySnakes as $snake) {
            if ($snake instanceof Snake) {
                $newStep = $this->getProbableMovementForOpponentSnake($snake, $enemySnakes);
                if ($newStep) {
                    array_push($steps, $newStep);
                }
            }
        }

        /*
         * Выбирается самый повторяющийся ход змеи союзника, если таковой имеется.
         * Иначе вычисляется самый простой ход соперника, против которого вычисляется ход союзника.
         */
        $step = $this->getTheMostRepetitiveElement($steps);
        if (!$step) {
            $enemySnakeProbableStep = $this->getProbableMovementForOpponentSnake($this->game->getEnemySnake(), array($this->game->getAllySnake()));
            $step = $this->getProbableMovementForOpponentSnake($this->game->getAllySnake(), array($this->getSteppedSnake($enemySnakeProbableStep, $this->game->getEnemySnake())));

            /*
             * Если ход не найден, то выбирается случайный ход из массива возможных ходов.
             */
            if (!$step) {
                $stepNumber = 0;
                try {
                    $stepNumber = random_int(0, count($steps));
                } catch (\Exception $e) {
                }
                $step = $steps[$stepNumber];

                if (!$step) {
                    foreach ($allySnakes as $snake) {
                        if ($this->checkSnake($snake[1])) {
                            return $snake[0];
                        }
                    }
                }
            }
        }

        return $step;
    }

    /**
     * Выбирает из всех возмжных ходов одной змеи самый логичный относительно соперника.
     *
     * @author Габдулхакова Дина
     * @param Snake $snake - Змея, против которой делается ход
     * @param array $opponentSnakeSteppedArray - Возможные ходы змеи, из которых выбирается нужный
     * @return null|string $step
     */
    private function getProbableMovementForOpponentSnake(Snake $snake, array $opponentSnakeSteppedArray)
    {
        $step = null;

        if (!empty($opponentSnakeSteppedArray)) {
            $step = $opponentSnakeSteppedArray[0][0];

            $opponentSnakeNumber = 0;
            $minDistanceBetweenSnakeHeadAndOpponentTail = Game::MAP_CELLS_COUNT;
            $minDistanceBetweenOpponentHeadAndSnakeTail = Game::MAP_CELLS_COUNT;

            for ($i = 0; $i < count($opponentSnakeSteppedArray); $i++) {
                if ($this->checkSnakesRelativeToEachOther($snake, $opponentSnakeSteppedArray[$i][1], true) < 2) {
                    if ($this->checkEnemySnakeCorrectBiteAllySnake($snake, $opponentSnakeSteppedArray[$i][1])) {
                        continue;
                    }
                    $minDistanceBetweenSnakeHeadAndOpponentTail = $this->getDistanceBetweenFirstSnakeHeadAndSecondSnakeTail($snake, $opponentSnakeSteppedArray[$i][1]);
                    $minDistanceBetweenOpponentHeadAndSnakeTail = $this->getDistanceBetweenFirstSnakeHeadAndSecondSnakeTail($opponentSnakeSteppedArray[$i][1], $snake);
                    $opponentSnakeSteppedArray = $i;
                }
            }

            if ($opponentSnakeNumber == 0) {
                return null;
            }

            for ($i = $opponentSnakeNumber; $i < count($opponentSnakeSteppedArray); $i++) {
                if ($this->checkSnakesRelativeToEachOther($snake, $opponentSnakeSteppedArray[$i], true) < 2) {
                    if ($this->checkEnemySnakeCorrectBiteAllySnake($snake, $opponentSnakeSteppedArray[$i][1])) {
                        continue;
                    }
                    $distanceBetweenSnakeHeadAndOpponentTail = $this->getDistanceBetweenFirstSnakeHeadAndSecondSnakeTail($snake, $opponentSnakeSteppedArray[$i][1]);
                    $distanceBetweenOpponentHeadAndSnakeTail = $this->getDistanceBetweenFirstSnakeHeadAndSecondSnakeTail($opponentSnakeSteppedArray[$i][1], $snake);
                    if ($distanceBetweenOpponentHeadAndSnakeTail <= $minDistanceBetweenOpponentHeadAndSnakeTail) {
                        if ($distanceBetweenSnakeHeadAndOpponentTail >= $minDistanceBetweenSnakeHeadAndOpponentTail) {
                            $step = $opponentSnakeSteppedArray[$i][0];
                        } else {
                            continue;
                        }
                    }
                }
            }
        }

        return $step;
    }

    /**
     * Возвращает массив всех моделей змеи с разными ходами.
     *
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
     * Возвращает модель сходившей змеи по определённому ходу.
     *
     * @param string $step
     * @param Snake $snake
     * @return Snake
     */
    private function getSteppedSnake(string $step, Snake $snake)
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
                {
                }
        }

        return new Snake($head, $body, $tail, $snake->getIsBitten());
    }

    /**
     * Возвращает расстояние между головой одной змеи и хвостом другой.
     *
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
     * Проверяет укусил ли соперник змею соперника за хвост:
     *  false, если нет,
     *  иначе true.
     *
     * @param Snake $enemySnake
     * @param Snake $allySnake
     * @return bool
     */
    private function checkEnemySnakeCorrectBiteAllySnake(Snake $enemySnake, Snake $allySnake)
    {
        if ($this->checkTwoCoordinates($enemySnake->getHead(), $allySnake->getTail())) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет укусил ли соперник змею соперника не по правилам:
     *  false, если нет,
     *  иначе true.
     *
     * @param Snake $enemySnake
     * @param Snake $allySnake
     * @return bool
     */
    private function checkEnemySnakeUncorrectBiteAllySnake(Snake $enemySnake, Snake $allySnake)
    {
        if ($this->checkSnakesRelativeToEachOther($enemySnake, $allySnake, true) > 0) {
            if (!$this->checkTwoCoordinates($enemySnake->getHead(), $allySnake->getTail())) {
                return true;
            }
        }
        return false;
    }

    /**
     * Проверяет на корректность местополежия двух змей(если дополнительный параметр принимает значение false):
     *  false, если змея пересикаются,
     *  иначе true.
     * Если дополнительный параметр принимает значение true, возвращает число пересечений змей.
     *
     * @param Snake $snake1
     * @param Snake $snake2
     * @param bool $getNum
     * @return bool|number
     */
    private function checkSnakesRelativeToEachOther(Snake $snake1, Snake $snake2, bool $getNum)
    {
        $count = 0;
        if (!$this->checkSnakeConcerningTheCoordinates($snake1, $snake2->getHead())) {
            $count++;
            if (!$getNum) {
                return false;
            }
        }

        if (!empty($snake2->getBody())) {
            foreach ($snake2->getBody() as $coordinates) {
                if (!$this->checkSnakeConcerningTheCoordinates($snake1, $coordinates)) {
                    $count++;
                    if (!$getNum) {
                        return false;
                    }
                }
            }
        }

        if (!$this->checkSnakeConcerningTheCoordinates($snake1, $snake2->getTail())) {
            $count++;
            if (!$getNum) {
                return false;
            }
        }

        if ($getNum) {
            return $count;
        }
        return true;
    }

    /**
     * Проверяет совпадение координат змеи и заданных координат:
     *  false, если змея находится на заданных координатах,
     *  иначе true.
     *
     * @param Snake $snake
     * @param array $coordinates
     * @return bool
     */
    private function checkSnakeConcerningTheCoordinates(Snake $snake, array $coordinates)
    {
        if (!$this->checkTwoCoordinates($snake->getHead(), $coordinates)) {
            return false;
        }

        if (!empty($snake->getBody())) {
            foreach ($snake->getBody() as $item) {
                if (!$this->checkTwoCoordinates($item, $coordinates)) {
                    return false;
                }
            }
        }

        if (!$this->checkTwoCoordinates($snake->getTail(), $coordinates)) {
            return false;
        }

        return true;
    }

    /**
     * Возвращает false, если координаты совпадают, иначе true.
     *
     * @param array $coordinates1
     * @param array $coordinates2
     * @return bool
     */
    private function checkTwoCoordinates(array $coordinates1, array $coordinates2)
    {
        if ($coordinates1[0] == $coordinates2[0] and $coordinates1[1] == $coordinates2[1]) {
            return false;
        }
        return true;
    }

    /**
     * Возвращает true, если змея целая и не выходит за поле,
     * иначе false.
     *
     * @param Snake $snake
     * @return bool
     */
    private function checkSnake(Snake $snake)
    {
        $head = $snake->getHead();
        foreach ($head as $x) {
            if (!$this->checkOutAbroad($x)) {
                return false;
            }
        }

        if (!empty($snake->getBody())) {
            foreach ($snake->getBody() as $item) {
                if ($item[0] == $head[0] and $item[1] == $head[1]) {
                    return false;
                }
                foreach ($item as $x) {
                    if (!$this->checkOutAbroad($x)) {
                        return false;
                    }
                }
            }
        }

        if ($snake->getTail()[0] == $head[0] and $snake->getTail()[1] == $head[1]) {
            return false;
        }
        foreach ($snake->getTail() as $x) {
            if (!$this->checkOutAbroad($x)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Возвращает true, если координата находится на поле боя,
     * иначе false.
     *
     * @param int $x
     * @return bool
     */
    private function checkOutAbroad(int $x)
    {
        if ($x < 0 or $x > Game::MAP_CELLS_COUNT) {
            return false;
        }
        return true;
    }

    /**
     * Возвращает самый повторяемый элемент(ход) в массиве ходов змеи.
     * Если нельзя выделить один конкретный ход, то возращает null.
     *
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