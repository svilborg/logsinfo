<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Parsers\ApacheLogParser;

class ApacheLogParserTest extends TestCase
{

    /**
     *
     * @return void
     */
    public function testParserAndFields()
    {
        $parser = new ApacheLogParser();

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

        $this->assertContains("ip", $parser->getFields());
        $this->assertContains("method", $parser->getFields());
        $this->assertContains("code", $parser->getFields());
        $this->assertContains("day", $parser->getFields());
        $this->assertContains("hour", $parser->getFields());
    }

    public function testEmpty()
    {
        $parser = new ApacheLogParser();

        $this->expectException(\Exception::class);

        $result = $parser->parse(__DIR__ . "/../data/empty");
    }
}
