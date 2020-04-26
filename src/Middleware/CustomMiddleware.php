<?php

namespace App\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

final class CustomMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $delay = (int) $envelope->getMessage()->getMailQueueObj()->getSendAt() - time();
        $envelope = $envelope->with(new DelayStamp($delay * 1000));

        return $stack->next()->handle($envelope, $stack);
    }
}
