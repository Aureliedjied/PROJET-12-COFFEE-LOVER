<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

    
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
            ->add('content', TextareaType::class, [
            'label' => 'Contenu de l\'article',
            'attr' => [
                'placeholder' => 'Saisissez le contenu ici',
                'rows' => 8
            ],
            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'image_uri' => true,
            ])
            ->add('subtitle', TextType::class, [
                'attr' => [
                'placeholder' => 'Ex: La méthode d\'extraction'
                ],
                'label' => 'Libéllé'
            ])
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
