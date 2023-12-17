<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\Question;
use App\Entity\Response;
use App\Form\ResponseType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
                $question = $event->getData();
                $form = $event->getForm();


                if ($options['add_mode'] && null !== $question) {
                    for ($i = 0; $i < 3; $i++) {
                        //checks whether the answer for index $i does not exist. This means that if the answer is not defined for a given question at this index, a new one must be added.
                        if (!isset($question->getResponses()[$i])) {
                            //adds an instance of Response to the list of responses to the question
                            $question->getResponses()->add(new Response());
                        }
                    }
                }

                $form->add('responses', CollectionType::class, [
                    'entry_type' => ResponseType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'data' => $question->getResponses(),
                ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'add_mode' => false,
        ]);
    }
}
