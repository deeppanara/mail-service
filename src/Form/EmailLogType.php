<?php

namespace App\Form;

use App\Entity\EmailLog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template_id')
            ->add('queue_id')
            ->add('subject')
            ->add('expected_sent_time')
            ->add('real_sent_at')
            ->add('is_sent')
            ->add('error')
            ->add('mailTo')
            ->add('content')
            ->add('cc')
            ->add('bcc')
            ->add('mail_from')
            ->add('reply_to')
            ->add('custom_tags')
            ->add('attachments')
            ->add('headers')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmailLog::class,
        ]);
    }
}
