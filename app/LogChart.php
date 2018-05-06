<?php
namespace App;

use gchart\gPieChart;

class LogChart
{

    const TYPE_IMAGE_CODE = 0;
    const TYPE_IMAGE_URL = 1;
    const TYPE_IMAGE_RENDER = 3;

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

    public function getChart($data, $count = 5, $outputType = 0)
    {
        if ($count > 0) {
            $data = array_slice($data, (- 1) * $count, $count, true);
        }

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

        if (self::TYPE_IMAGE_CODE === $outputType) {
            ob_start();
            $this->piChart->getImgCode();
            $output = ob_get_contents();
            ob_end_clean();
        }
        elseif(self::TYPE_IMAGE_URL  === $outputType) {
            $output = $this->piChart->getUrl();
        }
        elseif(self::TYPE_IMAGE_RENDER  === $outputType) {
            $this->piChart->renderImage();
        }
        else {
            throw new \Exception("Invalid Output Type");
        }

        return $output;
    }
}