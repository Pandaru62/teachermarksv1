<?php

namespace App\Form;

use App\Entity\Schoolclass;
use App\Entity\Students;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StudentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => array(
                    'class' => 'form-control my-3',
                    'placeholder' => 'ex. Uzumaki'
                ),
                'label' => 'Nom de famille'
            ])
            ->add('firstname', TextType::class, [
                'attr' => array(
                    'class' => 'form-control my-3',
                    'placeholder' => 'ex. Naruto'
                ),
                'label' => 'Prénom'
            ])
            ->add('schoolclass', EntityType::class, [
                'class' => Schoolclass::class,
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'form-select my-3'
                ),
                'label' => 'Classe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}
