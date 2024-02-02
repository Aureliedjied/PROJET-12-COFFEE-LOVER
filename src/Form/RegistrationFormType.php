<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'olivertwist@bao.com',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'L\'email ne peut pas être vide.']),
                    new Email(['message' => 'L\'email "{{ value }}" n\'est pas valide.']),
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Votre prénom',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le prénom ne peut pas être vide.']),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Votre nom',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom ne peut pas être vide.']),
                ],
            ]);

        // Check if the option "custom_option" is defined and egual to "edit"
        if (isset($options["custom_option"]) && $options["custom_option"] !== "edit") {
            $builder->add('password', RepeatedType::class, [
                'attr' => [
                    'placeholder' => '******',
                ],
                "type" => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent être identiques',
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe'],
                'options' => ['attr' => ['maxlength' => 4096]],
                'error_bubbling' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le mot de passe ne peut pas être vide.']),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
                        'max' => 255,
                    ]),
                ],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'custom_option' => "default"
        ]);
    }
}
