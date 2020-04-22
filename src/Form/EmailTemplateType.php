<?php

namespace App\Form;

use App\Entity\EmailTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identifier')
            ->add('name')
            ->add('subject')
            ->add('body_html')
            ->add('body_text')
//            ->add('sender_email')
//            ->add('sender_name')
//            ->add('status')
//            ->add('has_layout')
//            ->add('created_at')
//            ->add('updated_at')
//            ->add('email_group')
//            ->add('tags')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmailTemplate::class,
        ]);
    }
}
