<?php

namespace App\Tests\Util;


use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MailTest extends KernelTestCase
{
    protected $mailService;

    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->mailService = $kernel->getContainer()
            ->get('App\Manager\Mail');
    }

    public function testBase()
    {
        $this->mailService;
    }
}