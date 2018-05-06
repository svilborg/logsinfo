<?php
namespace App\Parsers;

class ParserStrategy
{
    /**
     * Get Parser by type
     * @param string $type
     * @return \App\Parsers\ApacheLogParser|\App\Parsers\SyslogParser
     */

    public function getParser($type = "syslog", $params = [])
    {
        if ($type == "apachelog") {
            $parser = new ApacheLogParser($params);
        } else {
            $parser = new SyslogParser($params);
        }

        return $parser;
    }
}