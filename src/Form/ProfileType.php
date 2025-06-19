<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomUtilisateur', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire']),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s\'-]+$/',
                        'message' => 'Le nom contient des caractères invalides.'
                    ]),
                ],
            ])
            ->add('prenomUtilisateur', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le prénom est obligatoire']),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s\'-]+$/',
                        'message' => 'Le prénom contient des caractères invalides.'
                    ]),
                ],
            ])
            ->add('emailUtilisateur', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'L\'email est obligatoire']),
                    new Regex([
                        'pattern' => '/^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/',
                        'message' => 'Veuillez entrer une adresse email valide.'
                    ]),
                ],
            ])
            ->add('currentPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new UserPassword(['message' => 'Mot de passe actuel incorrect']),
                ],
                'label' => 'Mot de passe actuel',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => false,
                'first_options' => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Répétez le nouveau mot de passe'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 8 caractères, incluant une majuscule, une minuscule et un chiffre.',
                    ]),
                    new Length(['min' => 8, 'minMessage' => 'Le mot de passe doit contenir au moins 8 caractères']),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}