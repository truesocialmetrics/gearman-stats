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
            'workers' => 5,
            'error' => false), Parser::statusLine("test2\t1\t3\t5\n"));
    }

    /**
     * @param string $inputString
     * @dataProvider badDataProvider
     */
    public function testBadData($inputString)
    {
        $this->assertEquals(array(
            'name' => '',
            'queue' => 0,
            'running' => 0,
            'workers' => 0,
            'error' => true), Parser::statusLine($inputString));
    }

    public function badDataProvider()
    {
        return array(
            array("\t1\t3\t5\n"),
            array("name\t3\t5\n"),
        );
    }
}