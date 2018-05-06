<?php
namespace Tests\Unit;

use App\LogChart;
use Tests\TestCase;
use gchart\gPieChart;

class LogChartTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);

        $gPie = new gPieChart(550);
        $logChart = new LogChart($gPie);

        $result = $logChart->getChart([], 0);

        $this->assertContains("img", $result);
        $this->assertContains("width", $result);
        $this->assertContains("height", $result);

        $result = $logChart->getChart([
            [
                "name" => [
                    "test",
                    "test2"
                ],

                "count" => [
                    77,
                    88
                ]

            ]
        ], 0);

        $this->assertContains("img", $result);
        $this->assertContains("width", $result);
        $this->assertContains("height", $result);
        $this->assertContains("88", $result);
        $this->assertContains("77", $result);
    }

    public function additionProvider()
    {
        return [
            [
                "name" => [
                    "test",
                    "test2"
                ],

                "count" => [
                    77,
                    88
                ]

            ]

        ];
    }
}
