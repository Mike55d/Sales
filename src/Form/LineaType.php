<?php

namespace App\Form;

use App\Entity\Linea;
use App\Entity\Unidad;
use App\Entity\TipoDispositivo;
use App\Entity\Operadora;
use App\Entity\UserLinea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class LineaType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('ddd', TextType::class, [
				'label'=>'DDD'
			])
			->add('numero')
			->add('operadora', EntityType::class ,[
				'class' => Operadora::class,
				'choice_label' => 'nombre'
			])
			->add('unidad', EntityType::class ,[
				'class' => Unidad::class,
				'choice_label' => 'nombre'
			])
			->add('userLinea', EntityType::class ,[
				'required' => false,
				'placeholder' => 'Seleccione un usuario',
				'class' => UserLinea::class,
				'choice_label' => 'nombre'
			])
			->add('chip')
			->add('serie')
			->add('tipo', EntityType::class ,[
				'class' => TipoDispositivo::class,
				'choice_label' => 'tipo'
			])
			->add('active')
			->add('internet')
			->add('observaciones', TextareaType::class,[
				'attr'=>['class'=>'form-control'],
				'required'=>false
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
