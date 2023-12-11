<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
                'attr' => [
                'placeholder' => 'Saisissez le titre ici',
            ],
            ])
            ->add('subtitle', TextType::class, [
                'attr' => [
                'placeholder' => 'Ex: La méthode d\'extraction'
                ],
                'label' => 'sous-titre de l\'article'
            ])
            ->add('content', TextareaType::class, [
            'label' => 'Contenu de l\'article',
            'attr' => [
                'placeholder' => 'Saisissez le contenu ici',
                'rows' => 8
            ],
            ])
            ->add('created_at', DateTimeType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
            ])
            ->add('source')
            ->add('picture', UrlType::class, [
                'label' => 'Image de l\'article',
                'help' => 'Une URL en http:// ou https://'
            ])
            // ->add('user')
            ->add('category', EntityType::class, [
                'class' => Category::class, 
                'choice_label' => 'title',
                'placeholder' => 'Sélectionnez une catégorie', 
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
