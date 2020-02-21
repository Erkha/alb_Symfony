<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Page;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
   /** @param array|mixed[] $options  */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => 'titre de la page'])
            ->add('topPage', null, ['label' => 'page mise en avant'])
            ->add('published', null, ['label' => 'publié'])
            ->add('resume', null, ['label' => 'texte mis en avant'])
            ->add('content', CKEditorType::class, [
                'config' => ['uiColor' => '#ffffff'],
                'label'=>'contenu de l\'article',
            ])
            ->add('parent', EntityType::class, [
                'label' => 'page parent',
                'class' => Page::class,
                'choice_label' => 'title',
                'multiple' => false,
                'expanded'=> false,
            ]);
            // ->add('topImage',IntegratedImageType::class, [
            //     'label'=>'image mise en avant'])
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
