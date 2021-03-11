<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numC',TextType::class,[
                'attr' => [
                    'placehelder' => " numéro",
                    'class' => 'form-control'
                ]
            ])
            ->add('dateC', DateTimeType::class, [
                'date_widget' => 'single_text'
            ])

            ->add('patient',EntityType::class,[
                'class'=>Patient::class,
                'choice_label'=>'id',

            ])
            ->add('text',CKEditorType::class,[
                'attr' => [
                    'placehelder' => "Conseils",
                    'class' => 'form-control'
                ]
            ])
            ->add('patient');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
