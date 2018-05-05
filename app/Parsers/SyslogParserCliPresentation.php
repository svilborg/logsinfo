<?php

namespace App\Parsers;

class SyslogParserCliPresentation implements ParserInterface
{


    private $trim;
    /**
     * @var int
     */
    private $count;

    public function __construct($trim = 81, $count = 10)
    {
        $this->trim = $trim;
        $this->count = $count;
    }

    public function parse($file = '/var/log/syslog')
    {

        $parser = new SyslogParser();
        $logs = $parser->parse($file);

        $data = [];

        foreach ($logs["data"] as $item) {
            unset($item["dtime"], $item["month"], $item["day"]);
            $item["msg"] = substr($item["msg"], 0, $this->trim) . " ..";

            $data[] = (array)$item;
        }

        $data = array_slice($data, (-1) * $this->count, $this->count, true);

        $logs["data"] = $data;

        return $logs;
    }
    public function getFields()
    {}

}
