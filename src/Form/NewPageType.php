<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Page;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewPageType extends AbstractType
{
   /** @param array|mixed[] $options  */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => 'titre de la page'])

            ->add('parent', EntityType::class, [
                'label' => 'page parent',
                'class' => Page::class,
                'choice_label' => 'title',
                'multiple' => false,
                'expanded'=> false,
                'placeholder' => 'Choose an option',
                'required' => false,
            ])
            ->add('topPage', null, ['label' => 'page mise en avant']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
