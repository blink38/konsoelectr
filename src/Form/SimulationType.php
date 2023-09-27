<?php

namespace App\Form;

use App\Entity\Facturation;
use App\Entity\Import;
use App\Entity\Simulation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SimulationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('facturation', EntityType::class, [
            'class' => Facturation::class,
            'choice_label' => 'libelle',
            'attr' => [
                'class' => 'browser-default'
            ]
            
        ]);

        $builder->add('data', EntityType::class, [
            'class' => Import::class,
            'choice_label' => 'libelle',
            'attr' => [
                'class' => 'browser-default'
            ]
            
        ]);
        $builder->add('ajouter', SubmitType::class, [
            'attr' => [
                'class' => 'btn light-blue darken-1'
            ]
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Simulation::class,
        ]);
    }
}
