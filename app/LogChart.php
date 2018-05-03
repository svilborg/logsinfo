<?php
namespace App;

use gchart\gPieChart;

class LogChart
{

    /**
     *
     * @var gPieChart
     */
    private $pChart = null;

    /**
     *
     * @param gPieChart $chart
     */
    public function __construct(gPieChart $chart = null)
    {
        $this->piChart = $chart;
    }

    public function getChart($data, $count = 5)
    {

        if ($count > 0) {
            $data = array_slice($data, (- 1) * $count, $count, true);
        }

        $chart = "";

        $counts = [];
        $names = [];

        foreach ($data as $items) {
            $counts[] = $items["count"];
            $names[] = $items["name"];
        }

        $this->piChart->clearDataSets();
        $this->piChart->addDataSet($counts);
        $this->piChart->setLabels($names);
        $this->piChart->setLegend($names);
        $this->piChart->setColors(array(
            "ff3344",
            "11ff11",
            "22aacc",
            "3333aa"
        ));

        ob_start();
        $this->piChart->getImgCode();
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}