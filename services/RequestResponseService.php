<?php
/**
 * Created by PhpStorm.
 * User: Arslan
 * Date: 24.04.2018
 * Time: 18:21
 */

namespace services;


interface RequestResponseService
{
    public function send_request($url);
}