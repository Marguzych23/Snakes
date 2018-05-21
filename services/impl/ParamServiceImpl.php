<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 19.05.2018
 * Time: 12:36
 */

namespace services\impl;

use forms\InitialRequestForm;
use forms\RequestParamWithStepForm;
use forms\SecondRequestParamForm;
use models\Game;
use services\ParamService;

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