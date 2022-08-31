<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Triks;

use App\Form\VideoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class TriksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class)
            ->add('description',TextareaType::class)
            ->add('groupes',EntityType::class,[
                'class'=> Group::class,
                'choice_label'=> 'Groupes',
                'label'=>'Groupe'
            ])
            ->add('images',FileType::class, [
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                // 'constraints' => [
                //     // new File([
                //     //     'maxSize' => '10M',
                //     //     'mimeTypes' => [
                //     //         'image/*',
                //     //     ],
                //     //     'maxSizeMessage' => 'le fichier est trop volumineux',
                //     //     'mimeTypesMessage'  => 'seul les images  sont autorisé',
                //     // ])
                // ],
            ])
                
            // ])
            ->add('video', CollectionType::class, [
                // each entry in the array will be an "email" field
                'entry_type' => VideoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,

                
            ])
            ->add('ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Triks::class,
        ]);
    }
}
