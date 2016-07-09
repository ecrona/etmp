<?php

namespace Etmp\Log;

use Etmp\Storage;
use DateTime;

class Logger implements LoggerInterface
{
    private $storage;

    public function __construct(Storage\Adapter $storage)
    {
        $this->storage = $storage;
    }

    private function interpolate(string $message, array $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace);
    }

    public function emergency(string $message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(string $message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(string $message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(string $message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(string $message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(string $message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(string $message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(string $message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function log(string $level, string $message, array $context = array())
    {
        $date = new DateTime();

        $metadata = [
            'date'  => $date->format('Y-m-d H:i:s'),
            'level' => $level,
        ];

        $this->storage->append('logs', $date, $this->interpolate($message, $context), $metadata);
    }

}