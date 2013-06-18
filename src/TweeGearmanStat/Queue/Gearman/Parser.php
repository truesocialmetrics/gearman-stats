<?php
namespace TweeGearmanStat\Queue\Gearman;

class Parser
{
    public static function statusLine($line)
    {
        $line = trim($line);
        $exploded = explode("\t", $line);
        
        if (count($exploded) != 4) {
            return array(
                'name'    => '',
                'queue'   => 0,
                'running' => 0,
                'workers' => 0,
            );
        }

        list($name, $queue, $running, $workers) = $exploded;
        
        return array(
            'name'    => $name,
            'queue'   => $queue,
            'running' => $running,
            'workers' => $workers,
        );
    }
}
