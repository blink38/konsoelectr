<?php

namespace App\Form;

use App\Entity\Facturation;
use App\Entity\Tarif;
use FFI;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);



        foreach (['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $key) {
            $builder->add($key, CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'required' => false,
            ]);
        }

        $builder->add('facturation', EntityType::class, [
            'class' => Facturation::class,
            'choice_label' => 'libelle',
            
        ]);

        $builder->add('date_debut', DateType::class, [
            'widget' => 'single_text',
            'input'  => 'datetime_immutable'
        ])->add('date_fin', DateType::class, [
            'widget' => 'single_text',
            'input'  => 'datetime_immutable'
        ]);


        // heure de début et de fin du tarif
        $builder->add('heure_debut', TimeType::class,[
            'widget' => 'single_text',
            'input'  => 'datetime_immutable',
            'html5' => true,
        ])->add('heure_fin', TimeType::class,[
            'widget' => 'single_text',
            'input'  => 'datetime_immutable'
        ]);

        $builder->add('tarif', NumberType::class, [
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        $builder->add('ajouter', SubmitType::class, [
            'attr' => [
                'class' => 'form-control'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarif::class,
        ]);
    }
}
