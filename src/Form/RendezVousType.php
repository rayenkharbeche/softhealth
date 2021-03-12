<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomRDV', TextType::class,[
                'label'=> 'Nom RendezVous' ,
                'attr'=>[
                    'placeholder' => 'Nom de RendezVous',
                    'class'=>'name'
                ]
            ])
            ->add('description')
            /*->add('dateRDV' ,DateTimeType::class, [
                'attr' =>['class' =>'RendezVousController js-datepicker'],
                'label' => 'Date Rendez Vous',
                'required' => FALSE,
                'widget' => 'single_text',
                'html5' => FALSE,
                'format' => 'MM/dd/yyyy'
            ])*/
            ->add('dateRDV' , DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('plannings')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
