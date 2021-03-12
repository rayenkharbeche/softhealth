<?php

namespace App\Form;

use App\Entity\Planning;

use phpDocumentor\Reflection\Types\False_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomP', TextType::class,[
                'label'=> 'Nom Planning' ,
                'attr'=>[
                    'placeholder' => 'Nom de Planning',
                    'class'=>'name'
                ]
            ])

            ->add('dateDebut', DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('dateFin', DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('descriptionP', TextType::class,[
                'label'=> 'Description' ,
                'attr'=>[
                    'placeholder' => 'Description de Planning',
                    'class'=>'name'
                ]
            ])
            ->add('renders')
            ->add('personnel')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
