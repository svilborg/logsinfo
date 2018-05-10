<?php
/**
 * Created by PhpStorm.
 * User: svilborg
 * Date: 01.05.18
 * Time: 18:08
 */
namespace App\Parsers;

interface ParserInterface
{

    /**
     * Parses and returns log data & stats
     *
     * @param string $file
     */
    public function parse($file = '/var/log/syslog');

    /**
     * Get Field names for statistics
     *
     * @return array List of fields
     */
    public function getStatsFields();
}