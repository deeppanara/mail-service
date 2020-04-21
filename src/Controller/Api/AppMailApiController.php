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

        $input = [
            'name' => [
                'last_name' => 'Potencier',
            ],
            'email' => 'test@email.tld',
            'simple' => 'hello',
            'eye_color' => 3,
            'file' => null,
            'password' => 'test',
            'tags' => [
                [
                    'slug' => 'symfony_doc',
                    'label' => 'symfony doc',
                ],
            ],
        ];

        // use the validator to validate the value
        $errors = $apiRequestValidator->validate($input);
        if (count($errors)) {
            return new JsonResponse($apiRequestValidator->getFormatedError());
        }
        dd($apiRequestValidator->getFormatedError());


    }
}
