<?php

namespace App\Form;

use App\Entity\Texte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminTexteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			->add('id', HiddenType::class, [
				'mapped' => false
			])
			->add('position', HiddenType::class, [
				'mapped' => false
			])
            ->add('texte_fr', TextareaType::class, [
				'mapped' => false
			])
            ->add('texte_en', TextareaType::class, [
				'mapped' => false
			])
			->add('creer_texte', SubmitType::class)
			->add('modifier_texte', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Texte::class,
        ]);
    }
}
