<?php

namespace Tomaj\Hermes\Handler;

use Tomaj\Hermes\MessageInterface;

class DumpHandler implements HandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(MessageInterface $message)
    {
        var_dump($message);
        return true;
    }
}