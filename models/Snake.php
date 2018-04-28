<?php
/**
 * Created by PhpStorm.
 * User: Marguzych
 * Date: 17.04.2018
 * Time: 19:23
 */

namespace models;

class Snake
{
    private $head;
    private $body;
    private $tail;
    private $isBitten;

    /**
     * Snake constructor.
     * @param $head
     * @param $body
     * @param $tail
     * @param $isBitten
     */
    public function __construct($head, $body, $tail, $isBitten)
    {
        $this->head = $head;
        $this->body = $body;
        $this->tail = $tail;
        $this->isBitten = $isBitten;
    }

    /**
     * @return mixed
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param mixed $head
     */
    public function setHead($head)
    {
        $this->head = $head;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * @param mixed $tail
     */
    public function setTail($tail)
    {
        $this->tail = $tail;
    }

    /**
     * @return bool
     */
    public function getIsBitten()
    {
        return $this->isBitten;
    }

    /**
     * @param bool $isBitten
     */
    public function setIsBitten(bool $isBitten)
    {
        $this->isBitten = $isBitten;
    }

}