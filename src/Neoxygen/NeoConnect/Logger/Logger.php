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

    public function debug($message, array $info = array())
    {
        return $this->logger->debug($message, $info);
    }

    public function info($message, array $info = array())
    {
        return $this->logger->info($message, $info);
    }

    public function emergency($message, array $info = array())
    {
        return $this->logger->emergency($message, $info);
    }

    public function log($level, $message, array $context = array())
    {
        return $this->logger->log($level, $message, $context);
    }
}
