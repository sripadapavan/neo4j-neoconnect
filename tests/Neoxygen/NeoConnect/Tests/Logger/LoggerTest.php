<?php

namespace Neoxygen\NeoConnect\Tests\Logger;

use Monolog\Logger as BaseLogger,
    Monolog\Handler\StreamHandler;
use Neoxygen\NeoConnect\Logger\Logger;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLoggerCanBeAdded()
    {
        $log = new BaseLogger('test');
        $ls = new Logger();
        $handle = fopen('php://memory', 'a+');
        $handler = new StreamHandler($handle);
        $handler->setFormatter($this->getIdentityFormatter());

        $observer = $this->getMock('Monolog\\Logger', array('log'), array('neotest'));
        $observer->pushHandler($handler);
        $observer->expects($this->exactly(3))
            ->method('log')
            ->withConsecutive(
                array('info', 'test', array()),
                array('debug', 'test2', array()),
                array('emergency', 'test3', array())
            );
        $ls->setLogger($observer);
        $ls->info('test', array());
        $ls->debug('test2', array());
        $ls->emergency('test3', array());
    }

    protected function getRecord($level = Logger::WARNING, $message = 'test', $context = array())
    {
        return array(
            'message' => $message,
            'context' => $context,
            'level' => $level,
            'level_name' => Logger::getLevelName($level),
            'channel' => 'test',
            'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true))),
            'extra' => array(),
        );
    }

    protected function getIdentityFormatter()
    {
        $formatter = $this->getMock('Monolog\\Formatter\\FormatterInterface');
        $formatter->expects($this->any())
            ->method('format')
            ->will($this->returnCallback(function ($record) { return $record['message']; }));

        return $formatter;
    }
}
