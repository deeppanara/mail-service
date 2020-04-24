<?php

namespace App\Command;

use App\Repository\EmailTemplateRepository;
use App\Service\MailSender;
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
     * @var MailSender
     */
    protected $mailSender;
    /**
     * @var EmailTemplateRepository
     */
    protected $emailTemplateRepository;

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


    public function __construct(MailSender $mailSender, EmailTemplateRepository $emailTemplateRepository)
    {
        $this->mailSender = $mailSender;
        $this->emailTemplateRepository = $emailTemplateRepository;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $emailTemps = $this->emailTemplateRepository->findAll();

        foreach ($emailTemps as $email) {
            echo ".";
            $this->mailSender->sendByIentifier($email->getIdentifier(), []);
        }

        return 0;
    }
}
