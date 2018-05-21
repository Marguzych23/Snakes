<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 23.04.2018
 * Time: 16:41
 */

spl_autoload_register(function ($class_name) {
    include_once $class_name . '.php';
});

use models\Game;
use models\Snake;
use services\impl\GameDataSharingService;
use services\impl\GameServiceImpl;
use services\impl\InitRequestResponseService;
use services\impl\MovementControlService;
use services\impl\ParamServiceImpl;

$url = "http://80.211.132.97:5000/snake";
$game = new Game(null, null, new Snake(null, null, null, false),
    new Snake(null, null, null, false));

$gameService = new GameServiceImpl($game);
$requestResponseService = new InitRequestResponseService();

/*
 * Инициализируем битву
 */
while (true) {
    $params = ParamServiceImpl::getInitialisation();
    $requestResponseService->send_request($url, $params);
    $game = $requestResponseService->getGame();
    if (!is_null($game)) {
        print_r("Run game");
        break;
    }
}

/*
 * Процесс битвы
 */
$gameDataSharingService = new GameDataSharingService();
$gameMovementControlService = new MovementControlService();
while (true) {
    $params = ParamServiceImpl::getRequestParamsForGettingGameData($game);
    $gameDataSharingService->send_request($url, $params);
    $emptyGame = $gameDataSharingService->getGame();
    if ($game instanceof Game and $emptyGame instanceof Game) {
        if ($game->getBattleId() == $emptyGame->getBattleId() and $game->getSnakeId() == $emptyGame->getSnakeId()) {
            $gameService = new GameServiceImpl($emptyGame);
            $step = $gameService->getStepForAllySnake();
            print_r("Our step $step\n");
            $params = ParamServiceImpl::getRequestParamsWithStep($emptyGame, $step);
            $gameMovementControlService->send_request($url, $params);
            print_r("Our step $step\n");

            /*
             * Окончание, если оно есть
             */
            if (!is_null($gameMovementControlService->getEndString())) {
//                print_r($gameMovementControlService->getEndString());
                break;
            }
        } else {
            continue;
        }
    }
}

