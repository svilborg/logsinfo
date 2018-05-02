<?php
/**
 * Created by PhpStorm.
 * User: svilborg
 * Date: 01.05.18
 * Time: 18:08
 */

namespace App;

interface ParserInterface
{
    public function parse($file = '/var/log/syslog');
}