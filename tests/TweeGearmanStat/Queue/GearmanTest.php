<?php
namespace TweeGearmanStat\Queue;
use PHPUnit_Framework_TestCase;
use PHPUnit_Framework_Assert;

class GearmanTest extends PHPUnit_Framework_TestCase
{
    public function testConnect()
    {
        $adapter = new Gearman(array(
            'default' => array('host' => '127.0.0.1', 'port' => 4730, 'timeout' => 1),
        ));
        $statuses = $adapter->status();
        $this->assertArrayHasKey('default', $statuses);
        $status = $statuses['default'];
        $this->assertContains(array('name' => 'test1', 'queue' => 0, 'running' => 0, 'workers' => 1), $status);
        $this->assertContains(array('name' => 'test2', 'queue' => 0, 'running' => 0, 'workers' => 1), $status);
    }
    
    public function testConnectWithDefaultTimeout()
    {
        $adapter = new Gearman(array(
            'default' => array('host' => '127.0.0.1', 'port' => 4730),
        ));
        $statuses = $adapter->status();
        $this->assertArrayHasKey('default', $statuses);
        $status = $statuses['default'];
        $this->assertContains(array('name' => 'test1', 'queue' => 0, 'running' => 0, 'workers' => 1), $status);
        $this->assertContains(array('name' => 'test2', 'queue' => 0, 'running' => 0, 'workers' => 1), $status);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testConnectWithNoServers()
    {
        $adapter = new Gearman(array());
    }

    public function testConnections()
    {
        $adapter = new Gearman(array(
            'default' => array('host' => '127.0.0.1', 'port' => 4730, 'timeout' => 1),
        ));
        $connections = $adapter->connections();
        $this->assertCount(1, $connections);
        $this->assertTrue(is_resource($connections['default']));
    }

    public function testDesturct()
    {
        $adapter = new Gearman(array(
            'default' => array('host' => '127.0.0.1', 'port' => 4730, 'timeout' => 1),
        ));
        $adapter->connections();
        $adapter->__destruct();
        $this->assertEquals(array(), PHPUnit_Framework_Assert::readAttribute($adapter, 'connections'));
    }
}
