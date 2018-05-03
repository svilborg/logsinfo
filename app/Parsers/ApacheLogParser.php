<?php
namespace App\Parsers;

use MVar\LogParser\SimpleParser;
use MVar\LogParser\LogIterator;

class ApacheLogParser implements ParserInterface
{

    use StatsTrait;

    const EXP = '/' .
    //
    '(?<ip>\d+\.\d+\.\d+\.\d+)\s+' .
    //
    '(?<x1>\S+)\s+' .
    //
    '(?<x2>\S+)\s+' .
    //
    '\[(?<time>.*)\]\s+' .
    //
    '\"(?<method>\S+)\s+' .
    //
    '(?<path>\S+)\s+' .
    //
    '(?<http>\S+)\s+' .
    //
    '(?<code>\d+)\s+' . '.*' . '/';

    /**
     *
     * @var SimpleParser
     */
    private $parser;

    private $log;

    public function __construct()
    {
        $this->parser = new SimpleParser(self::EXP);

        $this->log = [
            "data" => [],
            //
            "day" => [],
            "hour" => [],
            "ip" => [],
            "method" => [],
            // "path" => [],
            "code" => []
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Parsers\ParserInterface::parse()
     */
    public function parse($file = '')
    {
        $file = ! empty($file) ? $file : '/var/log/apache2/access.log.1';
        $i = 0;

        foreach (new LogIterator($file, $this->parser) as $data) {

            if ($data && isset($data["ip"])) {

                unset($data["x1"], $data["x2"]);

                $t = strtotime($data["time"]);

                $this->log["data"][$i] = $data;
                $this->log["data"][$i]["time"] = date("Y-m-d H:i:s", $t);

                $this->incStats("day", date("d", $t));
                $this->incStats("hour", date("H", $t));

                $this->incStats("ip", $data["ip"]);
                $this->incStats("method", $data["method"]);
                $this->incStats("code", $data["code"]);

                $i ++;
            }
        }

        $sum = array_sum(array_map(function ($a) {
            return $a["count"];
        }, $this->log["hour"]));

        $this->calcPerecent("day", $sum);
        $this->calcPerecent("hour", $sum);
        $this->calcPerecent("ip", $sum);
        $this->calcPerecent("method", $sum);
        $this->calcPerecent("code", $sum);

        usort($this->log["ip"], function ($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        usort($this->log["method"], function ($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        usort($this->log["code"], function ($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        return $this->log;
    }

    /**
     *
     * {@inheritdoc}
     * @see \App\Parsers\ParserInterface::getFields()
     */
    public function getFields()
    {
        $fields = [
            "day",
            "hour",
            "method",
            "ip",
            "code"
        ];

        return $fields;
    }
}