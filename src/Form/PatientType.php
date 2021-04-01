<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cin',TextType::class,[
                'attr' => [
                    'placehelder' => "Votre CIN",
                    'class' => 'form-control'
                ]
            ])
            ->add('nom',TextType::class,[
                'attr' => [
                    'placehelder' => "Nom",
                    'class' => 'form-control'
                ]
            ])
            ->add('prenom',TextType::class,[
                'attr' => [
                    'placehelder' => "Prénom",
                    'class' => 'form-control'
                ]
            ])
            ->add('email',EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('password', PasswordType::class)
            ->add('consultation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
