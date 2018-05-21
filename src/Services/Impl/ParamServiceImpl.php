<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 19.05.2018
 * Time: 12:36
 */

namespace Services\Impl;

use Forms\InitialRequestForm;
use Forms\RequestParamWithStepForm;
use Forms\SecondRequestParamForm;
use Models\Game;
use Services\ParamService;

class ParamServiceImpl implements ParamService
{

    public static function getRequestParamsForGettingGameData(Game $game)
    {
        $params = json_encode(new SecondRequestParamForm($game->getSnakeId(), $game->getBattleId()));
        return $params;
    }

    public static function getRequestParamsWithStep(Game $game, string $step)
    {
        $params = json_encode(new RequestParamWithStepForm($game->getSnakeId(), $game->getBattleId(), $step));
        return $params;
    }

    public static function getInitialisation()
    {
        return json_encode(new InitialRequestForm());
    }
}