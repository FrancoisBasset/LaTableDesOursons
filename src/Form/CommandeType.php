<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', null, [
				'label' => 'commande.prenom'
			])
            ->add('nom', null, [
				'label' => 'commande.nom'
			])
            ->add('prix', null, [
				'label' => 'commande.prix'
			])
            ->add('plats', null, [
				'label' => 'commande.plats'
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
