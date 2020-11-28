<?php

namespace App\Form;

use App\Entity\Linea;
use App\Entity\Unidad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LineaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('operadora')
            ->add('chip')
            ->add('tipo')
            ->add('unidad',EntityType::class ,[
                'class' => Unidad::class,
                'choice_label' => 'nombre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Linea::class,
        ]);
    }
}
