<?php

declare(strict_types=1);

/*
 * (c) 2022 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\Archive;
use App\Entity\ManuscriptSource;
use App\Entity\SourceCategory;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Source form.
 */
class ManuscriptSourceType extends TermType {
    private ?LinkableMapper $mapper = null;

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);
        $builder->add('callNumber', TextType::class, [
            'label' => 'Call Number',
            'required' => false,
            'attr' => [
                'help_block' => '',
            ],
        ]);

        $builder->add('sourceCategory', Select2EntityType::class, [
            'label' => 'SourceCategory',
            'class' => SourceCategory::class,
            'remote_route' => 'source_category_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'source_category_new_popup',
                'add_label' => 'Add SourceCategory',
            ],
        ]);

        $builder->add('archive', Select2EntityType::class, [
            'label' => 'Archive',
            'class' => Archive::class,
            'remote_route' => 'archive_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'archive_new_popup',
                'add_label' => 'Add Archive',
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
            'data_class' => ManuscriptSource::class,
        ]);
    }
}
