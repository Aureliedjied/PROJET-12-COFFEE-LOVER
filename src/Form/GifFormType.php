<?php

namespace App\Form;

use App\Entity\Gif;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GifFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre du Gif',
            'attr' => [
            'placeholder' => 'Saisissez le titre ici',
        ],
        ])
        ->add('pictureFile', VichImageType::class, [
            'label' => 'GIF',
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            'image_uri' => true,
        ])
        ->add('soundstrackFile', VichFileType::class, [
            'label' => 'son',
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gif::class,
        ]);
    }
}
