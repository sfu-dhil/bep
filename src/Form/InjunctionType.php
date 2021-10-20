<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\Injunction;

use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Injunction form.
 */
class InjunctionType extends AbstractType {
    private LinkableMapper $mapper;

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('title', TextType::class, [
            'label' => 'Title',
            'required' => true,
            'attr' => [
                'help_block' => 'As it appears in the ESTC',
            ],
        ]);
        $builder->add('uniformTitle', TextareaType::class, [
            'label' => 'Uniform Title',
            'required' => false,
            'attr' => [
                'help_block' => '',
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('variantTitles', CollectionType::class, [
            'label' => 'Variant Titles',
            'required' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'entry_type' => TextType::class,
            'entry_options' => [
                'label' => false,
            ],
            'by_reference' => false,
            'attr' => [
                'class' => 'collection collection-simple',
                'help_block' => "Year, followed by the title in modern English. Eg. '1631, A thanksgiving, and prayer for the safe child bearing of the queen's majesty'. Also add any other variant titles listed in the ESTC.",
            ],
        ]);
        $builder->add('author', TextType::class, [
            'label' => 'Author',
            'required' => false,
            'attr' => [
                'help_block' => '',
            ],
        ]);
        $builder->add('imprint', TextareaType::class, [
            'label' => 'Imprint',
            'required' => false,
            'attr' => [
                'class' => 'tinymce',
                'help_block' => 'A modern spelling imprint',
            ],
        ]);
        $builder->add('variantImprint', TextareaType::class, [
            'label' => 'Variant Imprint',
            'required' => false,
            'attr' => [
                'help_block' => 'Original spelling imprint and any variations of it',
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('date', TextType::class, [
            'label' => 'Date',
            'required' => false,
            'attr' => [
                'help_block' => '',
            ],
        ]);
        $builder->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => true,
            'attr' => [
                'help_block' => 'Public description of the item.',
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('estc', TextType::class, [
            'label' => 'Estc',
            'required' => false,
            'attr' => [
                'help_block' => '',
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
            'data_class' => Injunction::class,
        ]);
    }
}
