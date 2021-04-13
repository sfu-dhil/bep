<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\Archdeaconry;
use App\Entity\Diocese;
use Nines\MediaBundle\Form\LinkableType;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Archdeaconry form.
 */
class ArchdeaconryType extends TermType
{
    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);
        $builder->add('diocese', Select2EntityType::class, [
            'label' => 'Diocese',
            'class' => Diocese::class,
            'remote_route' => 'diocese_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'diocese_new_popup',
                'add_label' => 'Add Diocese',
            ],
        ]);
        LinkableType::add($builder, $options);
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     */
    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefaults([
            'data_class' => Archdeaconry::class,
        ]);
    }
}
