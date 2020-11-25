<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\Archdeaconry;
use App\Entity\Parish;
use App\Entity\Town;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Parish form.
 */
class ParishType extends TermType {
    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);

        $builder->add('archdeaconry', Select2EntityType::class, [
            'label' => 'Archdeaconry',
            'class' => Archdeaconry::class,
            'remote_route' => 'archdeaconry_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'archdeaconry_new_popup',
                'add_label' => 'Add Archdeaconry',
            ],
        ]);

        $builder->add('town', Select2EntityType::class, [
            'label' => 'Town',
            'class' => Town::class,
            'remote_route' => 'town_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => 'Town or Ward if in London',
                'add_path' => 'town_new_popup',
                'add_label' => 'Add Town',
            ],
        ]);
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     */
    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefaults([
            'data_class' => Parish::class,
        ]);
    }
}
