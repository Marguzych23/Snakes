<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 20.05.2018
 * Time: 1:54
 */

namespace forms;


class SecondRequestParamForm
{

    public $snake_id;
    public $battle_id;

    /**
     * SecondRequestParamForm constructor.
     * @param $snake_id
     * @param $battle_id
     */
    public function __construct($snake_id, $battle_id)
    {
        $this->snake_id = $snake_id;
        $this->battle_id = $battle_id;
    }

    /**
     * @return mixed
     */
    public function getSnakeId()
    {
        return $this->snake_id;
    }

    /**
     * @param mixed $snake_id
     */
    public function setSnakeId($snake_id): void
    {
        $this->snake_id = $snake_id;
    }

    /**
     * @return mixed
     */
    public function getBattleId()
    {
        return $this->battle_id;
    }

    /**
     * @param mixed $battle_id
     */
    public function setBattleId($battle_id): void
    {
        $this->battle_id = $battle_id;
    }


}