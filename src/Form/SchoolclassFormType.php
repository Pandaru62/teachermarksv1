<?php

namespace App\Form;

use App\Entity\Schoolclass;
use App\Entity\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchoolclassFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => array(
                    'class' => 'form-control my-3',
                ),
                'label' => 'Nom de la classe : '
            ])
            ->add('color', ColorType::class, [
                'attr' => array(
                    'class' => 'form-control my-3 w-25',
                ),
                'label' => 'Couleur associée'
            ])
            ->add('isArchived', CheckboxType::class, [
                'required' => false,
                'attr' => array(
                    'class' => 'form-check-input',
                ),
                'label' => 'Classe archivée ',
                'label_attr' => ['class' => 'form-check-label'],
            ])
            ->add('form', EntityType::class, [
                'class' => Form::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Niveau ',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Schoolclass::class,
        ]);
    }
}
