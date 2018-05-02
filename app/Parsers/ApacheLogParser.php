<?php
namespace App\Parsers;

use MVar\LogParser\SimpleParser;
use MVar\LogParser\LogIterator;

class ApacheLogParser implements ParserInterface
{

    const EXP1 = '/' .
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

    public function parse($file = '')
    {
        $file = ! empty($file) ? $file : '/var/log/apache2/access.log.1';
        $i = 0;

        foreach (new LogIterator($file, $this->parser) as $data) {

            if ($data && isset($data["prog"])) {
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
        $this->calcPerecent("prog", $sum);
        $this->calcPerecent("hour", $sum);
        $this->calcPerecent("user", $sum);

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

    private function calcPerecent($field, $sum)
    {
        foreach ($this->log[$field] as $key => $item) {
            $perc = round(((int) $item["count"] / $sum) * 100);
            $this->log[$field][$key]["percent"] = $perc . " %";
        }
    }

    private function incStats($stat, $field)
    {
        if (! isset($this->log[$stat][$field])) {
            $this->log[$stat][$field] = [
                "name" => $field,
                "count" => 1
            ];
        } else {
            $this->log[$stat][$field]["count"] ++;
        }
    }
}
