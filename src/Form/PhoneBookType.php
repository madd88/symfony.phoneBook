<?php

namespace App\Form;

use App\Entity\PhoneBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('full_name', TextType::class, [
                'label' => 'ФИО',
                'attr' => [
                    'style' => 'width:20%',
                    'class' => 'form-control'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Номер телефона',
                'attr' => [
                    'style' => 'width:20%',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PhoneBook::class,
        ]);
    }
}
