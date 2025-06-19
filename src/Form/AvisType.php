<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomAvis', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex('/^[a-zA-Z\s]+$/', 'Le nom ne doit contenir que des lettres et des espaces.'),
                ],
                'label' => 'Nom',
            ])
            ->add('commentaireAvis', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Commentaire',
            ])
            ->add('noteAvis', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Note (entre 1 et 5)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
