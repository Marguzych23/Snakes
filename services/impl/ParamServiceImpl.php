<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 19.05.2018
 * Time: 12:36
 */

namespace services\impl;


use forms\RequestParamWithStepForm;
use forms\SecondRequestParamForm;
use models\Game;
use services\ParamService;

class ParamServiceImpl implements ParamService
{

    public static function getRequestParamsForGettingGameData(Game $game)
    {
//        $params = "{"
//                     ."snake_id:".$game->getSnakeId().","
//                     ."battle_id:".$game->getBattleId()
//                    ."}";
        $snake_id = $game->getSnakeId();
        $battle_id = $game->getBattleId();
        $params = '{"snake_id":"' . $snake_id . '", "battle_id":"' . $battle_id . '""}';
        return $params;
    }

    public static function getRequestParamsWithStep(Game $game, string $step)
    {
//        $params = "{"
//            ."step:'".$step."',"
//            ."snake_id:".$game->getSnakeId().","
//            ."battle_id:".$game->getBattleId()
//            ."}"; $
        $snake_id = $game->getSnakeId();
        $battle_id = $game->getBattleId();
        $params = '{"step":"' . $step . '", "snake_id":"' . $snake_id . '", "battle_id":"' . $battle_id . '""}';
        return $params;
    }

    public function getInitialization($param) {
        $params = '{"answer":"' . $param . '"}';
        return $params;
    }
}
