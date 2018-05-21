<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 21.05.2018
 * Time: 4:30
 */

namespace gui\impl;


use gui\GameGUI;
use models\Game;
use models\Snake;

class ConsoleGameGUI implements GameGUI
{

    private $game;
    private $battlefield;

    const TAIL_PRESENTS = "*";
    const BODY_PRESENTS = "=";
    const ALLY_HEAD_PRESENTS = "@";
    const ENEMY_HEAD_PRESENTS = "#";

    /**
     * ConsoleGameGUI constructor.
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function draw()
    {
        $tempArray = array_fill(0, Game::MAP_CELLS_COUNT, 0);
        $this->battlefield = array_fill(0, Game::MAP_CELLS_COUNT, $tempArray);

        $this->addSnakeOnBattlefield($this->game->getAllySnake(), true);
        $this->addSnakeOnBattlefield($this->game->getEnemySnake(), false);

        $map = "";
        for ($i = 0; $i < Game::MAP_CELLS_COUNT; $i++) {
            for ($j = 0; $j < Game::MAP_CELLS_COUNT; $j++) {
                $map .= "|".$this->battlefield[$i][$j];
            }
            $map .= "|\n";
        }

        print_r($map);
    }

    /**
     * @param Snake $snake
     * @param bool $isAlly
     */
    private function addSnakeOnBattlefield(Snake $snake, bool $isAlly) {
        if ($isAlly) {
            $head = ConsoleGameGUI::ALLY_HEAD_PRESENTS;
        } else {
            $head = ConsoleGameGUI::ENEMY_HEAD_PRESENTS;
        }
        $this->battlefield[$snake->getHead()[0]][$snake->getHead()[1]] = $head;
        $this->battlefield[$snake->getTail()[0]][$snake->getTail()[1]] = ConsoleGameGUI::TAIL_PRESENTS;
        if (!empty($snake->getBody())) {
            foreach ($snake->getBody() as $body) {
                $this->battlefield[$body[0]][$body[1]] = ConsoleGameGUI::BODY_PRESENTS;
            }
        }
    }

    /**
     * @param Game $game
     */
    public function setGame(Game $game): void
    {
        $this->game = $game;
    }
}