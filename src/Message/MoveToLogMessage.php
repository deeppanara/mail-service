<?php

namespace App\Message;

final class MoveToLogMessage
{
    private $mailQueue;

    public function __construct($mailQueue)
    {
        $this->mailQueue = $mailQueue;
    }

    public function getMailQueueId()
    {
        return $this->mailQueue;
    }
}
