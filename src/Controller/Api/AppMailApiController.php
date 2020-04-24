<?php

namespace App\Controller\Api;

use App\Validator\ApiRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AppMailApiController extends AbstractController
{
    /**
     * @Route("/mail/send", name="app_mail_api")
     */
    public function mailSend(Request $request, ApiRequestValidator $apiRequestValidator)
    {

        $input = '
{
  "template_id": "85A198B56B2D08C01",
  "from": {
    "email": "noreplyjohndoe.com",
    "name": "John Doe"
  },
  "reply_to": {
    "email": "noreply@johndoe.com",
    "name": "John Doe"
  },
  "personalizations": {
      "to": [
        {
          "email": "john.doeexample.com",
          "name": "John Doe"
        }
      ],
      "cc": [
        {
          "email": "john.doe@example.com",
          "name": "John Doe"
        }
      ],
      "bcc": [
        {
          "email": "john.doe@example.com",
          "name": "John Doe"
        }
      ],
      "custom_tags": {
        "verb": "",
        "adjective": "",
        "noun": "",
        "currentDayofWeek":     ""
      },
      "send_at": "-12323232323",
      "subject": "Hello, World!"
    }
}';

        // use the validator to validate the value
        $errors = $apiRequestValidator->validate(json_decode($input, true));

        if ($errors) {
            return new JsonResponse($apiRequestValidator->getFormatedError());
        }
        dd($apiRequestValidator->getFormatedError());


    }
}
