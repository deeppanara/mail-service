<?php

namespace App\Command;

use App\Service\MailSender;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class EmailGunCommand extends Command
{
    protected static $defaultName = 'app:email:gun';

    /**
     * @var SymfonyStyle
     */
    protected $io;
    /**
     * @var MailSender
     */
    protected $mailSender;

    protected function configure()
    {
        $this
            ->setDescription('test all mail')
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }


    public function __construct(MailSender $mailSender)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->mailSender = $mailSender;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->mailSender->sendByIentifier('Email-Registration', []);

        return 0;
    }
}
