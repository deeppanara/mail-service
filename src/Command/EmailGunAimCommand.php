<?php

namespace App\Command;

use App\Manager\MailManager;
use App\Provider\ContentProvider;
use App\Repository\EmailTemplateRepository;
use App\Service\MailSenderService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EmailGunAimCommand extends Command
{
    protected static $defaultName = 'mail:gun:aim';

    /**
     * @var SymfonyStyle
     */
    protected $io;
    /**
     * @var MailSenderService
     */
    protected $mailSender;
    /**
     * @var EmailTemplateRepository
     */
    protected $emailTemplateRepository;
    /**
     * @var MailManager
     */
    protected $mailManager;
    /**
     * @var ContentProvider
     */
    protected $contentProvider;

    protected function configure()
    {
        $this
            ->setDefinition([
            ])
            ->setDescription('Fire all mail for system assurance')
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> Fire all mail form EmailTemplate by MailManger:

<info>php bin/console mail:gun:aim</info>

EOF
            );

    }

    public function __construct(MailSenderService $mailSender, MailManager $mailManager, EmailTemplateRepository $emailTemplateRepository, ContentProvider $contentProvider)
    {
        $this->mailSender = $mailSender;
        $this->mailManager = $mailManager;
        $this->emailTemplateRepository = $emailTemplateRepository;
        $this->contentProvider = $contentProvider;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $emailTemps = $this->emailTemplateRepository->findAll();

        foreach ($emailTemps as $email) {
            echo ".";

            $this->mailManager->init();
            $this->mailManager->setTo('recipient222@example.com');
            $this->mailManager->setFrom("deep@aspl.sasas", "sasas");

            $subject = $this->contentProvider->render($email->getSubject(), []);
            $body = $this->contentProvider->render($email->getBodyHtml(), []);

            $this->mailManager->setSubject($subject);
            $this->mailManager->setBody($body);
            $this->mailManager->send();
        }

        return 0;
    }
}
