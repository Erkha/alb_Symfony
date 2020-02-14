<?php

declare(strict_types=1);

namespace App\Form\Contacter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /** @param array|mixed[] $options **/
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'attr'=> ['class' => 'form-control','placeholder' => 'votre nom'],
        ])
        ->add('email', EmailType::class, [
            'attr'=> ['class' => 'form-control','placeholder' => 'votre email'],
        ])
        ->add('phone', TelType::class, [
            'attr'=> ['class' => 'form-control','placeholder' => 'votre téléphone'],
        ])
        ->add('message', TextareaType::class, [
            'attr'=> ['class' => 'form-control','placeholder' => 'votre message', 'rows' => 5],
        ])
        ->add('send', SubmitType::class, [
            'attr'=> ['class' => 'btn btn-primary btn-xl'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
