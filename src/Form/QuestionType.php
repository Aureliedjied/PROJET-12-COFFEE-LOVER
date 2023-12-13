<?php

namespace App\Form;

use App\Entity\Question;
use App\Form\ResponseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text_question')
            ->add('responses', CollectionType::class, [
                'entry_type' => ResponseType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true


            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
