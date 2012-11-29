<?php
namespace TweeGearmanStat\Queue\Gearman;
use PHPUnit_Framework_TestCase;
class ParserTest extends PHPUnit_Framework_TestCase
{
    public function testConnect()
    {
        $this->assertEquals(array(
            'name' => 'test2',
            'queue' => 1,
            'running' => 3,
            'workers' => 5), Parser::statusLine("test2\t1\t3\t5\n"));
    }
}