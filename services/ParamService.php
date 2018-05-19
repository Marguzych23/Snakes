<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 19.05.2018
 * Time: 12:32
 */

namespace services;


use models\Game;

interface ParamService
{
    public static function getRequestParamsForGettingGameData(Game $game);

    public static function getRequestParamsWithStep(Game $game, string $step);
}