<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class NewPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'mot de passe',
                    'attr' => [
                        'placeholder' => 'votre mot de passe '
                    ]
                ],
                'second_options' => [
                    'label' => 'comfirmer  mot de passe',
                    'attr' => [
                        'placeholder' => ' comfirmer mot de passe '
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe ',
                    ]),
                ],
                'label' => 'mot de passe',
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
