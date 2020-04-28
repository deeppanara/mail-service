<?php

namespace App\Command;

use App\Manager\MailManager;
use App\Message\MailQueue;
use App\Provider\ContentProvider;
use App\Repository\EmailTemplateRepository;
use App\Service\MailSenderService;
use App\Validator\ApiRequestValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class EmailGunMmgCommand extends Command
{
    protected static $defaultName = 'mail:gun:mmg';
    protected $io;
    protected $emailTemplateRepository;
    protected $mailManager;
    protected $contentProvider;
    protected $apiRequestValidator;
    protected $bus;
    protected $mailSenderService;

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
        MailSenderService $mailSenderService,
        MailManager $mailManager,
        EmailTemplateRepository $emailTemplateRepository,
        ContentProvider $contentProvider,
        ApiRequestValidator $apiRequestValidator,
        MessageBusInterface $bus
    )
    {
        parent::__construct();

        $this->mailSenderService = $mailSenderService;
        $this->mailManager = $mailManager;
        $this->emailTemplateRepository = $emailTemplateRepository;
        $this->contentProvider = $contentProvider;
        $this->apiRequestValidator = $apiRequestValidator;
        $this->bus = $bus;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $count = $input->getOption('round', 0);
        do {
            echo ".";
            $this->fireSingleMail();
            $count--;
        } while($count > 0);

        return 0;
    }

    /**
     * @param InputInterface $input
     */
    protected function fireSingleMail(): void
    {
        $emailTemps = $this->emailTemplateRepository->findAll();
        $emilGroup = $emailTemps[array_rand($emailTemps)];
        $faker = \Faker\Factory::create();
        dump($emilGroup->getIdentifier());
        $reqData = [
            "template_id" => $emilGroup->getIdentifier(),
            "from" => [
                "email" => $faker->email,
                "name" => $faker->name
            ],
            "reply_to" => [
                "email" => $faker->email,
                "name" => $faker->name
            ],
            "personalizations" => [
                "to" => [
                    [
                        "email" => $faker->email,
                        "name" => $faker->name
                    ],
                    [
                        "email" => $faker->email,
                        "name" => $faker->name
                    ],
                    [
                        "email" => $faker->email,
                        "name" => $faker->name
                    ]
                ],
                "cc" => [
                    [
                        "email" => $faker->email,
                        "name" => $faker->name
                    ],
                ],
                "bcc" => [
                    [
                        "email" => $faker->email,
                        "name" => $faker->name
                    ],
                ],
                "custom_tags" => [
                    "verb" => "",
                    "adjective" => "",
                    "noun" => "",
                    "currentDayofWeek" => "",
                ]
            ],
        ];

//        $errors = $this->apiRequestValidator->validate($reqData);
//
//        if ($errors) {
//            var_dump($this->apiRequestValidator->getFormatedError());
//        } else {
            $queueObj = $this->mailSenderService->processRequest($reqData);
//        }

        $mailqueue = new MailQueue($queueObj);
        $this->bus->dispatch($mailqueue);
    }
}
