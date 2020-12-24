<?php

namespace App\Form;

use App\Entity\Unidad;
use App\Entity\Asociacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UnidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('nombre')
            ->add('encargado')
            ->add('emailEncargado')
            ->add('endereso')
            ->add('asociacion', EntityType::class ,[
				'class' => Asociacion::class,
				'choice_label' => 'nombre'
			])
            ->add('ciudad')
            ->add('emailDetallado')
            ->add('nombre')
            ->add('activa')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Unidad::class,
        ]);
    }
}
