<?php
namespace TweeGearmanStat\Queue;

class Gearman
{
    const OPTION_HOST = 'host';
    const OPTION_PORT = 'port';
    const OPTION_TIMEOUT = 'timeout';

    private $defaultTimeout = 5;

    protected $connections = array();

    public function __construct(array $servers)
    {
        foreach ($servers as $name => $options) {
            $error = '';
            $errno = 0;
            $timeout = isset($options[self::OPTION_TIMEOUT]) ? $options[self::OPTION_TIMEOUT] : $this->defaultTimeout;
            $socket  = fsockopen($options[self::OPTION_HOST], $options[self::OPTION_PORT], $error, $errno, $timeout );
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
                $parsedResponse = Gearman\Parser::statusLine($line);

                if (!empty($parsedResponse['name'])) {
                    $response []= $parsedResponse;
                }
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