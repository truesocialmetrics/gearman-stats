<?php
namespace TweeGearmanStat\Queue;

class Gearman
{
    const OPTION_HOST = 'host';
    const OPTION_PORT = 'port';
    const OPTION_TIMEOUT = 'timeout';

    protected $connections = array();

    public function __construct(array $servers)
    {
        foreach ($servers as $name => $options) {
            $error = '';
            $errno = 0;
            $socket = fsockopen($options[self::OPTION_HOST], $options[self::OPTION_PORT], $error, $errno, $options[self::OPTION_TIMEOUT]);
            $this->connections[$name] = $socket;
        }
    }

    public function status()
    {
        $responses = array();
        foreach ($this->connections as $name => $socket) {
            $body = trim($this->command($socket, 'status'));
            $response = array();
            foreach (explode("\n", $body) as $line) {
                $response[] = Gearman\Parser::statusLine($line);
            }
            $responses[$name] = $response;
        }
        return $responses;
    }

    protected function command($socket, $command)
    {
        fwrite($socket, $command . PHP_EOL);
        $response = '';
        while (($line = fgets($socket)) !== false) {
            if (trim($line) == '.') break;
            $response .= $line;
        }
        return $response;
    }
}