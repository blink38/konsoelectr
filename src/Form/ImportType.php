<?php

namespace App\Form;

use App\Entity\Import;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class)
            ->add('file', FileType::class, [
                
                'mapped' => false,
                'required' => true,

                // 'constraints' => [
                //     new File([
                //         'maxSize' => '16000k',
                //         'mimeTypes' => ['application/csv', 'text/csv'],
                //         'mimeTypesMessage' => 'Please upload a valid CSV file.'
                //     ])
                // ]
            ])

            ->add('importer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn light-blue darken-1'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Import::class,
        ]);
    }
}
