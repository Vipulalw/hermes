<?php

namespace Tomaj\Hermes\Driver;

use Tomaj\Hermes\MessageInterface;
use Closure;

interface DriverInterface
{
    /**
     * Send message
     *
     * In this method you have to implement logic to insert messages to process in queue.
     * This method has to be as fast as possible because it will be called in
     * web server threads.
     *
     * @param MessageInterface   $message
     *
     * @return $this
     */
    public function send(MessageInterface $message);

    /**
     * Processing wait method.
     *
     * Dispatcher will call this method for receiving data from driver.
     * This can be implemented as infinite loop and checking driver in periodic time for new messages
     * or can be implemented as callback for driver emit method (like rabbitmq or redis pubsub).
     * When driver receive new message, you have to call $callback with this message like $callback($message)
     *
     * @param Clousure  $callback
     *
     * @return void
     */
    public function wait(Closure $callback);
}
