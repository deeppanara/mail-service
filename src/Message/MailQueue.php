<?php

namespace App\Message;

use App\Entity\EmailQueue;

final class MailQueue
{
    private $mailQueue;

    public function __construct(EmailQueue $mailQueue)
    {
        $this->mailQueue = $mailQueue;
    }

    public function getMailQueueObj(): EmailQueue
    {
        return $this->mailQueue;
    }
}
