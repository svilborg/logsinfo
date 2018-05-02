<?php
namespace App\Parsers;

class ParserStrategy
{
    /**
     * Get Parser by type
     * @param string $type
     * @return \App\Parsers\ApacheLogParser|\App\Parsers\SyslogParser
     */

    public static function getParser($type = "syslog")
    {
        if ($type == "apachelog") {
            $parser = new ApacheLogParser();
        } else {
            $parser = new SyslogParser();
        }

        return $parser;
    }
}