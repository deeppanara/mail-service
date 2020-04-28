<?php

namespace App\MessageHandler;

use App\Manager\MailManager;
use App\Message\MailQueue;
use App\Message\MoveToLogMessage;
use App\Service\MailSenderService;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

final class MailQueueHandler implements MessageHandlerInterface
{
    /**
     * @var MailSenderService
     */
    private $mailSenderService;

    /**
     * @var MessageBusInterface
     */
    private $eventBus;
    /**
     * @var MailManager
     */
    public $mailManager;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(
        MessageBusInterface $eventBus,
        MailSenderService $mailSenderService,
        MailManager $mailManager,
        \Swift_Mailer $mailer
    )
    {
        $this->mailSenderService = $mailSenderService;
        $this->eventBus = $eventBus;
        $this->mailManager = $mailManager;
        $this->mailer = $mailer;
    }

    public function __invoke(MailQueue $message)
    {
        try {
            $this->mailSenderService->sendMailFromQueue($message->getMailQueueObj());
        } catch (\Exception $exception) {
            dd($exception);
        }


        $event = new MoveToLogMessage($message->getMailQueueObj()->getId());
        $this->eventBus->dispatch(
            (new Envelope($event))
                ->with(new DispatchAfterCurrentBusStamp())
        );
    }
}
