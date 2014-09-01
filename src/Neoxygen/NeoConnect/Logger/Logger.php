<?php

namespace Neoxygen\NeoConnect\Logger;

use Psr\Log\LoggerInterface;

class Logger
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function processLog($level, $message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }

    public function debug($message, array $info = array())
    {
        return $this->processLog('debug', $message, $info);
    }

    public function info($message, array $info = array())
    {
        return $this->processLog('info', $message, $info);
    }

    public function emergency($message, array $info = array())
    {
        return $this->processLog('emergency', $message, $info);
    }

    public function log($level, $message, array $context = array())
    {
        return $this->processLog($level, $message, $context);
    }
}
