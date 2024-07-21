<?php

namespace App\Form;

use App\Entity\Students;
use App\Entity\StudentTest;
use App\Entity\Test;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentTestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mark', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                ],
                'label' => 'Note'
            ])
            ->add('skill1', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                    'min' => 0,
                    'max' => 4,
                ],
                'label' => 'LECTURE',
                'required' =>  false
            ])
            ->add('skill2', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                    'min' => 0,
                    'max' => 4,
                ],
                'label' => 'CONNAISSANCES',
                'required' =>  false
            ])
            ->add('skill3', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                    'min' => 0,
                    'max' => 4,
                ],
                'label' => 'ARGUMENTATION',
                'required' =>  false
            ])
            ->add('skill4', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                    'min' => 0,
                    'max' => 4,
                ],
                'label' => 'ECRIT',
                'required' =>  false
            ])
            ->add('skill5', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control my-3',
                    'min' => 0,
                    'max' => 4,
                ],
                'label' => 'ORAL',
                'required' =>  false
            ])
            // ->add('student', EntityType::class, [
            //     'class' => Students::class,
            //     'choice_label' => function (Students $student) {
            //         return $student->getLastname() . ' ' . $student->getFirstname();
            //     },
            // ])
            // ->add('test', EntityType::class, [
            //     'class' => Test::class,
            //     'choice_label' => 'description',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentTest::class,
        ]);
    }
}
