<?php
namespace TweeGearmanStat\Queue\Gearman;

class Parser
{
    public static function statusLine($line)
    {
        $line = trim($line);

        $exploded = explode("\t", $line);

        list($name, $queue, $running, $workers) = (count($exploded) == 4) ? $exploded : array('', 0, 0, 0);

        return array(
            'name'    => $name,
            'queue'   => $queue,
            'running' => $running,
            'workers' => $workers,
        );
    }
}