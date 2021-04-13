<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\Book;
use App\Entity\Format;
use Nines\MediaBundle\Form\LinkableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Book form.
 */
class BookType extends AbstractType
{
    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('title', TextareaType::class, [
            'label' => 'Title',
            'required' => false,
            'attr' => [
                'help_block' => 'A modern-spelling title',
                'class' => '',
            ],
        ]);
        $builder->add('uniformTitle', TextareaType::class, [
            'label' => 'Uniform Title',
            'required' => false,
            'attr' => [
                'help_block' => '',
                'class' => '',
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

            'attr' => [
                'class' => 'collection collection-simple',
                'help_block' => 'Original spelling title and any variants of it',
            ],
        ]);
        $builder->add('author', TextType::class, [
            'label' => 'Author',
            'required' => false,
            'attr' => [
                'help_block' => '',
            ],
        ]);
        $builder->add('publisher', TextareaType::class, [
            'label' => 'Publisher',
            'required' => false,
            'attr' => [
                'help_block' => '',
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
            'required' => false,
            'attr' => [
                'help_block' => '',
                'class' => 'tinymce',
            ],
        ]);

        $builder->add('format', Select2EntityType::class, [
            'label' => 'Format',
            'class' => Format::class,
            'remote_route' => 'format_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'format_new_popup',
                'add_label' => 'Add Format',
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
            'data_class' => Book::class,
        ]);
    }
}
