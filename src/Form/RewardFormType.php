<?php

namespace App\Form;

use App\Entity\Reward;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RewardFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre de la récompense',
            'attr' => [
            'placeholder' => 'Saisissez le titre ici',
        ],
        ])
        ->add('pictureFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            'image_uri' => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reward::class,
        ]);
    }
}
