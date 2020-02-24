<?php

/*
 * This file is part of the fa bundle.
 *
 * @copyright Copyright (c) 2017, Fiare Oy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Mail
{
    /**
     * Mailer service class object.
     *
     * @var object
     */
    protected $mailer;

    /**
     * Entity Manager class object.
     *
     * @var object
     */
    protected $em;

    /**
     * Swift_Message class object.
     *
     * @var object
     */
    protected $message;

    /**
     * Container service class object.
     *
     * @var object
     */
    protected $container;

    /**
     * History entity manager.
     *
     * @var object
     */
    private $historyEntityManager;

    /**
     * Constructor.
     *
     * @param object $mailer
     * @param object $em
     * @param object $container
     */
    public function __construct(\Swift_Mailer $mailer, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();

        //$this->historyEntityManager = $this->container->get('doctrine')->getManager('history');
    }

}
