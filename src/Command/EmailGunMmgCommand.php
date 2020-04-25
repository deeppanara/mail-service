<?php

namespace App\Command;

use App\Manager\MailManager;
use App\Repository\EmailTemplateRepository;
use App\Service\MailSender;
use App\Twig\ContentProvider;
use App\Validator\ApiRequestValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmailGunMmgCommand extends Command
{
    protected static $defaultName = 'mail:gun:mmg';

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
    /**
     * @var MailManager
     */
    protected $mailManager;
    /**
     * @var ContentProvider
     */
    protected $contentProvider;
    /**
     * @var ApiRequestValidator
     */
    protected $apiRequestValidator;

    protected function configure()
    {
        $this
            ->setDefinition([
            ])
            ->setDescription('Fire all mail for system assurance')
            ->addOption(
                'round',
                null,
                InputOption::VALUE_OPTIONAL,
                'no of mail.'
            )
            ->setHelp(<<<'EOF'
The <info>%command.name%</info> Fire all mail form mail send api:

<info>

php bin/console mail:gun:mmg
php bin/console mail:gun:mmg --round=1000

</info>

EOF
            );

    }

    public function __construct(
        MailSender $mailSender,
        MailManager $mailManager,
        EmailTemplateRepository $emailTemplateRepository,
        ContentProvider $contentProvider,
        ApiRequestValidator $apiRequestValidator
    )
    {
        $this->mailSender = $mailSender;
        $this->mailManager = $mailManager;
        $this->emailTemplateRepository = $emailTemplateRepository;
        $this->contentProvider = $contentProvider;
        $this->apiRequestValidator = $apiRequestValidator;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

//        $emailTemps = $this->emailTemplateRepository->findAll();
        if ($input->getOption('round') !== null) {
            $i = $input->getOption('round');
            while($i >= 0) {
                echo ".";
                $this->FireSingleMail();
                $i--;
            }


        }

        return 0;
    }

    /**
     * @param InputInterface $input
     */
    protected function FireSingleMail(): void
    {
        $reqData = [
            "template_id" => "60AAFB00E42FA3D6",
            "from" => [
                "email" => "norepl@yjohndoe.com",
                "name" => "John Doe"
            ],
            "reply_to" => [
                "email" => "noreply@johndoe.com",
                "name" => "John Doe"
            ],
            "personalizations" => [
                "to" => [
                    [
                        "email" => "john.doe@example.com",
                        "name" => "John Doe"
                    ]
                ],
                "cc" => [
                    [
                        "email" => "john.doe@example.com",
                        "name" => "John Doe"
                    ],
                ],
                "bcc" => [
                    [
                        "email" => "john.doe@example.com",
                        "name" => "John Doe"
                    ],
                ],
                "custom_tags" => [
                    "verb" => "",
                    "adjective" => "",
                    "noun" => "",
                    "currentDayofWeek" => "",
                ],
                "send_at" => time() + rand(-10, 20),
                "subject" => "Hello, World!"
            ],
        ];

        $errors = $this->apiRequestValidator->validate($reqData);

        if ($errors) {
            var_dump($this->apiRequestValidator->getFormatedError());
        } else {
            $this->mailSender->processRequest($reqData);
        }
    }
}
