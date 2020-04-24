<?php

namespace App\Validator;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function foo\func;

class ApiRequestValidator
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;
    /**
     * @var \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    protected $errors;

    protected $data;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($data)
    {
        $this->data = $data;
        $input = '
{
  "template_id": "USER-USER-NOT-LOGGED-IN-FOR-A-WHILE-COMPANY-USER",
  "from": {
    "email": "noreply@johndoe.com",
    "name": "John Doe"
  },
  "reply_to": {
    "email": "noreply@johndoe.com",
    "name": "John Doe"
  },
  "personalizations": {
      "to": [
        {
          "email": "john.doe@example.com",
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
        "currentDayofWeek": ""
      },
      "send_at": "9999999999",
      "subject": "Hello, World!"
    }
}';

        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'template_id' => new Assert\Length(['min' => 16, 'max' => 16]),
            'from' => new Assert\Collection([
                'email' => new Assert\Email(),
                'name' => new Assert\Length(['min' => 1]),
            ]),
            'reply_to' => new Assert\Collection([
                'email' => new Assert\Email(),
                'name' => new Assert\Length(['min' => 1]),
            ]),
            'personalizations' => new Assert\Collection([
                'send_at' => new Assert\Optional([
                    new Assert\Length(['min' => 10]),
                    new Assert\Positive(),
                ]),
                'subject' => new Assert\Length(['min' => 1]),
                'to' => new Assert\Collection([
                    new Assert\Collection([
                        'email' => new Assert\Email(),
                        'name' => new Assert\Length(['min' => 1]),
                    ])
                ]),
                'cc' => new Assert\Optional([
                    new Assert\Type('array'),
                    new Assert\Count(['min' => 1]),
                    new Assert\All([
                        new Assert\Collection([
                            'email' => new Assert\Email(),
                            'name' => new Assert\Length(['min' => 1]),
                        ]),
                    ]),
                ]),
                'bcc' => new Assert\Optional([
                    new Assert\Type('array'),
                    new Assert\Count(['min' => 1]),
                    new Assert\All([
                        new Assert\Collection([
                            'email' => new Assert\Email(),
                            'name' => new Assert\Length(['min' => 1]),
                        ]),
                    ]),
                ]),
                'custom_tags' => new Assert\Optional([
                    new Assert\Type('array'),
                ]),
            ]),
//            'tags' => new Assert\Optional([
//                new Assert\Type('array'),
//                new Assert\Count(['min' => 1]),
//                new Assert\All([
//                    new Assert\Collection([
//                        'slug' => [
//                            new Assert\NotBlank(),
//                            new Assert\Type(['type' => 'string'])
//                        ],
//                        'label' => [
//                            new Assert\NotBlank(),
//                        ],
//                    ]),
//                ]),
//            ]),
        ]);

        $this->errors = $this->validator->validate($data, $constraint);
//dd($this->errors);
        return $this->errors->count();
    }

    public function getFormatedError()
    {
        return $this->formateErrors();
    }

    private function formateErrors()
    {
        $formatedError['data'] = $this->data;
        if ($this->errors->count()) {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $errorArray = $serializer->normalize($this->errors, null,
                [
                    'attributes' => [
                        "messageTemplate", "parameters", "plural", "message", "propertyPath", "invalidValue", "cause", "code"
                    ]
                ]
            );

            foreach ($errorArray as $error) {
                preg_match_all("/\[([^\]]*)\]/", $error['propertyPath'], $matches, PREG_PATTERN_ORDER);
                $formatedError['errors_message'][implode(',', $matches[1])] =  $error['message'];

            }

            dd($formatedError);
        }
        $formatedError['status'] = $this->errors->count() ? 'fail' : 'pass';
        $formatedError['errors'] = $errorArray ?? [];
dd($formatedError);
        return $formatedError;
    }


}
