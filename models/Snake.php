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
    private $id;
    private $head;
    private $body;
    private $tail;
    private $isBite;

    /**
     * Snake constructor.
     * @param $id
     * @param $head
     * @param $body
     * @param $tail
     * @param $isBite
     */
    public function __construct($id, $head, $body, $tail, $isBite)
    {
        $this->id = $id;
        $this->head = $head;
        $this->body = $body;
        $this->tail = $tail;
        $this->isBite = $isBite;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return mixed
     */
    public function getIsBite()
    {
        return $this->isBite;
    }

    /**
     * @param mixed $isBite
     */
    public function setIsBite($isBite)
    {
        $this->isBite = $isBite;
    }


}