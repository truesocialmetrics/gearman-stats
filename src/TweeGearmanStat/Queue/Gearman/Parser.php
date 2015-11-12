<?php
namespace TweeGearmanStat\Queue\Gearman;

class Parser
{
    const NAME    = 'name';
    const QUEUE   = 'queue';
    const RUNNING = 'running';
    const WORKERS = 'workers';
    const ERROR   = 'error';

    public static function statusLine($line)
    {
        $line = trim($line);
        $exploded = explode("\t", $line);
        
        if (count($exploded) != 4) {
            return array(
                self::NAME    => '',
                self::QUEUE   => 0,
                self::RUNNING => 0,
                self::WORKERS => 0,
                self::ERROR   => true,
            );
        }

        list($name, $queue, $running, $workers) = $exploded;
        
        return array(
            self::NAME    => $name,
            self::QUEUE   => $queue,
            self::RUNNING => $running,
            self::WORKERS => $workers,
            self::ERROR   => false,
        );
    }
}
