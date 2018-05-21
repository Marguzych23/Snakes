<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 23.04.2018
 * Time: 16:41
 */

use GUI\Impl\ConsoleGameGUI;
use Models\Game;
use Models\Snake;
use Services\Impl\GameDataSharingService;
use Services\Impl\GameServiceImpl;
use Services\Impl\InitRequestResponseService;
use Services\Impl\MovementControlService;
use Services\Impl\ParamServiceImpl;

spl_autoload_register(function ($class_name) {
    include_once $class_name . '.php';
});


$url = "http://80.211.132.97:8888/snake";
$game = new Game(null, null, new Snake(null, null, null, false),
    new Snake(null, null, null, false), null);

$gameService = new GameServiceImpl($game);
$requestResponseService = new InitRequestResponseService();
$gui = new ConsoleGameGUI($game);

/*
 * Инициализируем битву
 */
while (true) {
    $params = ParamServiceImpl::getInitialisation();
    $requestResponseService->send_request($url, $params);
    $game = $requestResponseService->getGame();
    if (!is_null($game)) {
        print_r("Run game\n");
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

    /*
     * Окончание, если оно есть
     */
    if (!is_null($gameDataSharingService->getEndString())) {
        print_r($gameDataSharingService->getEndString());
        break;
    }
    $emptyGame = $gameDataSharingService->getGame();
    if ($game instanceof Game and $emptyGame instanceof Game) {
        if ($game->getBattleId() == $emptyGame->getBattleId() and $game->getSnakeId() == $emptyGame->getSnakeId()) {
            $gui->setGame($emptyGame);
            $gui->draw();

            $gameService = new GameServiceImpl($emptyGame);
            $step = $gameService->getStepForAllySnake();
            print_r("Our step $step\n");
            $a = $game->getSnakeId();
            print_r("$a --- $step\n");
            $params = ParamServiceImpl::getRequestParamsWithStep($emptyGame, $step);
            $gameMovementControlService->send_request($url, $params);
        } else {
            continue;
        }
    }
}

