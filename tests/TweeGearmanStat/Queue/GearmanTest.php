<?php
namespace TweeGearmanStat\Queue;
use PHPUnit_Framework_TestCase;
class GearmanTest extends PHPUnit_Framework_TestCase
{
    public function testConnect()
    {
        $adapter = new Gearman(array(
            'default' => array('host' => '127.0.0.1', 'port' => 4730, 'timeout' => 1),
        ));
        $statuses = $adapter->status();
        $this->assertContains(array('name' => 'test1', 'queue' => 0, 'running' => 0, 'workers' => 1), $statuses);
        $this->assertContains(array('name' => 'test2', 'queue' => 0, 'running' => 0, 'workers' => 1), $statuses);
    }
}