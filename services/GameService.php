<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 23.04.2018
 * Time: 15:39
 */

namespace services;


interface GameService
{

    public function getStepForSmartSnake();

    public function getProbableMovementForOpponentSnake();
}