<?php
namespace TweeGearmanStat\Queue;

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
        $this->servers = $servers;
    }

    public function status()
    {
        $responses = array();
        $this->setConnections();
        foreach ($this->getConnections() as $name => $socket) {
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

    /**
     * @return bool
     */
    protected function setConnections()
    {
        if (empty($this->servers)) {
            return false;
        }
        $error = '';
        $errno = 0;
        $timeout = isset($options[self::OPTION_TIMEOUT]) ? $options[self::OPTION_TIMEOUT] : $this->defaultTimeout;
        foreach ($this->servers as $name => $options) {
            $this->connections[$name] =
                fsockopen(
                    $options[self::OPTION_HOST],
                    $options[self::OPTION_PORT],
                    $error,
                    $errno,
                    $timeout
                );
        }

        return true;
    }

    /**
     * @return array<resource>
     */
    public function getConnections()
    {
        return $this->connections;
    }
}
