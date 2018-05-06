<?php
namespace Tests\Unit;

use App\Parsers\SyslogParser;
use Tests\TestCase;

class SyslogParserTest extends TestCase
{

    /**
     * @return void
     */
    public function testParserAndFields()
    {
        $parser = new SyslogParser([]);

        $result = $parser->parse(__DIR__ . "/../data/syslog");

        $this->assertArrayHasKey("data", $result);
        $this->assertArrayHasKey("day", $result);
        $this->assertArrayHasKey("prog", $result);
        $this->assertArrayHasKey("user", $result);

        // Data
        $this->assertCount(10, $result["data"]);
        $this->assertCount(10, $result["data"]);

        // User Stats
        $this->assertEquals("user", $result["user"][0]["name"]);
        $this->assertEquals(10, $result["user"][0]["count"]);
        $this->assertEquals("100 %", $result["user"][0]["percent"]);

        $this->assertContains("prog", $parser->getFields());
        $this->assertContains("day", $parser->getFields());
        $this->assertContains("hour", $parser->getFields());
    }

    public function testEmpty()
    {
        $parser = new SyslogParser([]);

        $this->expectException(\Exception::class);

        $parser->parse(__DIR__ . "/../data/empty");
    }
}
