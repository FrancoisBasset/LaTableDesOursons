<?php

namespace App\Form;

use App\Entity\CommandeMenu;
use App\Entity\Menu;
use App\Entity\Plat;
use App\Repository\PlatRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('menu', EntityType::class, [
				'class' => Menu::class,
				'choice_label' => 'nom',
				'mapped' => false
			])
			->add('plats', EntityType::class, [
				'label' => 'commande.plats',
				'class' => Plat::class,
				'choice_label' => 'nom',
				'mapped' => false,
				'multiple' => true,
				'group_by' => function($choice) {
					if (isset($choice->getCategoriePlats()[0])) {
						return $choice->getCategoriePlats()[0]->getNom();
					}

					return '';
				}
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeMenu::class,
        ]);
    }
}
