<?php

namespace App\Form;

use App\Entity\Schoolclass;
use App\Entity\Test;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                ],
                'label' => 'Nom de l\'évaluation'
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control my-3',
                ]
            ])
            ->add('trimester', ChoiceType::class, [
                'choices'  => [
                    'TR 1' => 1,
                    'TR 2' => 2,
                    'TR 3' => 3,
                ],
                'attr' => [
                    'class' => 'form-control my-3',
                ],
                'label' => 'Trimestre',

            ])
            ->add('scale', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                    'value' => '20',
                ],
                'label' => 'Barême / Note maximale',
            ])
            ->add('coefficient', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                    'value' => '1'
                ],
            ])
            ->add('schoolclass', EntityType::class, [
                'class' => Schoolclass::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control my-3',
                ],
                'label' => 'Classe concernée',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
