<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Location;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut', null, [
                'widget' => 'single_text',
                'label' => 'Début de mission',
                'attr' => ['class' => 'form-control bg-dark text-light border-secondary'],
            ])
            ->add('date_fin', null, [
                'widget' => 'single_text',
                'label' => 'Fin de mission',
                'required' => false,
                'attr' => ['class' => 'form-control bg-dark text-light border-secondary'],
            ])
            ->add('id_film', EntityType::class, [
                'class' => Film::class,
                'choice_label' => 'titre',
                'label' => 'Film sélectionné',
                'placeholder' => 'Choisir un film...',
                'attr' => ['class' => 'form-select bg-dark text-light border-secondary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
