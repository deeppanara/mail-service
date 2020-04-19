<?php
require('vendor/autoload.php');

// Create the Transport
$transport = (new Swift_SmtpTransport('127.0.0.1', 1025))
    ->setUsername('your username')
    ->setPassword('your password')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
    ->setFrom(['john@doe.com' => 'John Doe'])
    ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
    ->setBody('Here is the message itself')
;

// Send the message
$result = $mailer->send($message);