<?php

namespace Tomaj\Hermes;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Tomaj\Hermes\Driver\DriverInterface;

class Emitter implements EmitterInterface
{
    /**
     * Dispatcher driver
     *
     * @var DriverInterface
     */
    private $driver;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Create new Dispatcher
     *
     * @param DriverInterface $driver
     * @param LoggerInterface $logger
     */
    public function __construct(DriverInterface $driver, LoggerInterface $logger = null)
    {
        $this->driver = $driver;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function emit(MessageInterface $message)
    {
        $this->driver->send($message);

        $this->log(
            LogLevel::INFO,
            "Dispatcher send message #{$message->getId()} to driver " . get_class($this->driver),
            $this->messageLoggerContext($message)
        );
        return $this;
    }

    /**
     * Serialize message to logger context
     *
     * @param MessageInterface $message
     *
     * @return array
     */
    private function messageLoggerContext(MessageInterface $message)
    {
        return [
            'id' => $message->getId(),
            'created' => $message->getCreated(),
            'type' => $message->getType(),
            'payload' => $message->getPayload(),
        ];
    }

    /**
     * Interal log method wrapper
     *
     * @param string $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    private function log($level, $message, array $context = array())
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }
}
