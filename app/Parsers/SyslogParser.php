<?php
namespace App;

use MVar\LogParser\SimpleParser;
use MVar\LogParser\LogIterator;

class SyslogParser implements ParserInterface
{

    const EXP = '/(?<month>\w+\S+)\s+' .
    //
    '(?<day>\d+)\s+' .
    //
    '(?<dtime>\d\d\:\d\d\:\d\d)\s+' .
    //
    '(?<user>\S+)\s+' .
    //
    '(?<prog>\S+)\[\S+\]\S+\s+' .
    //
    // '[(?<pids>\S+)]\s+' .
    //
    '(?<msg>.+)/';

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
            "user" => [],
            "prog" => []
        ];
    }

    public function parse($file = '')
    {
        $file = !empty($file) ? $file : '/var/log/syslog';
        $i = 0;

        foreach (new LogIterator($file, $this->parser) as $data) {

            if ($data && isset($data["prog"])) {
                $t = strtotime($data["month"] . " " . $data["day"] . " " . $data["dtime"]);

                $this->log["data"][$i] = $data;
                $this->log["data"][$i]["time"] = date("Y-m-d H:i:s", $t);

                $this->incStats("day", date("d", $t));
                $this->incStats("hour", date("H", $t));

                $this->incStats("user", $data["user"]);
                $this->incStats("prog", $data["prog"]);

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

        usort($this->log["user"], function ($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        usort($this->log["prog"], function ($a, $b) {
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
