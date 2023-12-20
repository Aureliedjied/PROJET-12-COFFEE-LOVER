<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Form\ResponseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text_question', TextType::class, [
                'label' => 'Titre de l\'article',
                'attr' => [
                    'placeholder' => 'Saisissez le titre ici',
                ],
            ])
            ->add('quizzes', EntityType::class, [
                'class' => Quiz::class,
                'choice_label' => 'title',
                'placeholder' => 'Sélectionner un Quiz',
                'multiple' => true,
                'expanded' => false
            ])
            ->add('responses', CollectionType::class, [
                'entry_type' => ResponseType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'add_mode' => false,
        ]);
    }
}
