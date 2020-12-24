<?php

namespace App\Form;

use App\Entity\UserLinea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserLineaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('telefono')
            ->add('email')
            ->add('orden',ChoiceType::class,[
                'choices' => [
                    'Orden I' => 'Orden I',
                    'Orden II' => 'Orden II',
                    'Otros' => 'Otros',
                ],
            ])
            ->add('active')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserLinea::class,
        ]);
    }
}
