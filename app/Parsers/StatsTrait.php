<?php
namespace App\Parsers;

trait StatsTrait {

    private $log;

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