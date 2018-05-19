<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 20.05.2018
 * Time: 1:55
 */

namespace forms;


class RequestParamWithStepForm
{

    public $snake_id;
    public $battle_id;
    public $step;

    /**
     * RequestParamWithStepForm constructor.
     * @param $snake_id
     * @param $battle_id
     * @param $step
     */
    public function __construct($snake_id, $battle_id, $step)
    {
        $this->snake_id = $snake_id;
        $this->battle_id = $battle_id;
        $this->step = $step;
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

    /**
     * @return mixed
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param mixed $step
     */
    public function setStep($step): void
    {
        $this->step = $step;
    }


}