<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\MicroPost;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


/**
 * 
 */
class MicroPostType extends AbstractType
{
	
	// function __construct(argument)
	// {
	// 	# code...
	// }

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('text', TextareaType::class, ['label' => false])
		->add('save', SubmitType::class);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		parent::configureOptions(
			$resolver->setDefaults([
				'data_class' => MicroPost::class
			])
		);
	}
}