<?php
namespace TweeGearmanStat\Queue;
use UnexpectedValueException;

class Gearman
{
    const OPTION_HOST = 'host';
    const OPTION_PORT = 'port';
    const OPTION_TIMEOUT = 'timeout';

    private $defaultTimeout = 5;

    protected $connections = array();

    protected $servers = array();

    public function __construct(array $servers)
    {
        if (empty($servers)) {
            throw new UnexpectedValueException('Empty servers list');
        }
        $this->servers = $servers;
    }

    public function __destruct()
    {
        foreach ($this->connections() as $name => $socket) {
            if (!is_resource($socket)) continue;
            fclose($socket);
        }
        $this->connections = array();
    }

    public function connections()
    {
        if (count($this->connections)) {
            return $this->connections;
        }
        foreach ($this->servers as $name => $options) {
            $error = '';
            $errno = 0;
            $timeout = isset($options[self::OPTION_TIMEOUT]) ? $options[self::OPTION_TIMEOUT] : $this->defaultTimeout;
            $socket  = fsockopen($options[self::OPTION_HOST], $options[self::OPTION_PORT], $error, $errno, $timeout );
            $this->connections[$name] = $socket;
        }
        return $this->connections;
    }

    public function status()
    {
        $responses = array();
        foreach ($this->connections() as $name => $socket) {
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
