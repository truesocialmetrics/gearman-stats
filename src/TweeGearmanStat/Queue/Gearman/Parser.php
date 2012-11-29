<?php
namespace TweeGearmanStat\Queue\Gearman;

class Parser
{
    public static function statusLine($line)
    {
        $line = trim($line);
        list($name, $queue, $running, $workers) = explode("\t", $line);
        return array(
            'name'    => $name,
            'queue'   => $queue,
            'running' => $running,
            'workers' => $workers,
        );
    }
}