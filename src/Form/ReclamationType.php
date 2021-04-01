<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Date;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire', CKEditorType::class ,[
                'attr' => [
                    'placehelder' => "Conseils",
                    'class' => 'form-control'
                ]
            ])
            ->add('type', TextType::class,[
                'attr' => [
                    'placehelder' => "type",
                    'class' => 'form-control'
                ]
            ])
            ->add('etat', TextType::class,[
                'attr' => [
                    'placehelder' => "etat",
                    'class' => 'form-control'
                ]
            ])
            ->add('user')
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
