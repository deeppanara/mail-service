<?php

namespace App\Validator;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($value)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'name' => new Assert\Collection([
                'first_name' => new Assert\Length(['min' => 101]),
                'last_name' => new Assert\Length(['min' => 1]),
            ]),
            'email' => new Assert\Email(),
            'simple' => new Assert\Length(['min' => 102]),
            'eye_color' => new Assert\Choice([3, 4]),
            'file' => new Assert\File(),
            'password' => new Assert\Length(['min' => 60]),
            'tags' => new Assert\Optional([
                new Assert\Type('array'),
                new Assert\Count(['min' => 1]),
                new Assert\All([
                    new Assert\Collection([
                        'slug' => [
                            new Assert\NotBlank(),
                            new Assert\Type(['type' => 'string'])
                        ],
                        'label' => [
                            new Assert\NotBlank(),
                        ],
                    ]),
                ]),
            ]),
        ]);

        $this->errors = $this->validator->validate($value, $constraint);
        return $this->errors;
    }

    public function getFormatedError()
    {
        return $this->formateErrors();
    }

    private function formateErrors()
    {
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $errorArray = $serializer->normalize($this->errors, null,
            [
                'attributes' => [
                    "messageTemplate", "parameters", "plural", "message", "root", "propertyPath", "invalidValue", "cause", "code"
                ]
            ]
        );

        return $errorArray;
    }


}
