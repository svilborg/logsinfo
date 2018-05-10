<?php
namespace Tests\Unit;

use App\Parsers\ApacheLogParser;
use Tests\TestCase;

class ApacheLogParserTest extends TestCase
{

    /**
     *
     * @return void
     */
    public function testParserAndFields()
    {
        $parser = new ApacheLogParser([]);

        $result = $parser->parse(__DIR__ . "/../data/accesslog");

        $this->assertArrayHasKey("data", $result);
        $this->assertArrayHasKey("day", $result);
        $this->assertArrayHasKey("method", $result);
        $this->assertArrayHasKey("code", $result);
        $this->assertArrayHasKey("ip", $result);

        // Data
        $this->assertCount(4, $result["data"]);

        // Ip Stats
        $this->assertEquals("179.219.43.80", $result["ip"][0]["name"]);
        $this->assertEquals(4, $result["ip"][0]["count"]);

        $this->assertContains("ip", $parser->getStatsFields());
        $this->assertContains("method", $parser->getStatsFields());
        $this->assertContains("code", $parser->getStatsFields());
        $this->assertContains("day", $parser->getStatsFields());
        $this->assertContains("hour", $parser->getStatsFields());
    }

    public function testEmpty()
    {
        $parser = new ApacheLogParser();

        $this->expectException(\Exception::class);

        $parser->parse(__DIR__ . "/../data/empty");
    }
}
