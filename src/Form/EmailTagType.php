<?php

namespace App\Form;

use App\Entity\EmailTag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('code')
            ->add('default')
            ->add('decreption')
            ->add('created_at')
            ->add('updated_at')
            ->add('email_template')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmailTag::class,
        ]);
    }
}
