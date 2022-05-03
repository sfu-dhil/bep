<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\County;
use App\Entity\Nation;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * County form.
 */
class CountyType extends TermType {
    private ?LinkableMapper $mapper = null;

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);
        $builder->add('nation', Select2EntityType::class, [
            'label' => 'Nation',
            'class' => Nation::class,
            'remote_route' => 'nation_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'nation_new_popup',
                'add_label' => 'Add Nation',
            ],
        ]);
        LinkableType::add($builder, $options);
        $builder->setDataMapper($this->mapper);
    }

    /**
     * @required
     */
    public function setMapper(LinkableMapper $mapper) : void {
        $this->mapper = $mapper;
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     */
    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefaults([
            'data_class' => County::class,
        ]);
    }
}
