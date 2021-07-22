<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\Book;
use App\Entity\Inventory;
use App\Entity\Monarch;
use App\Entity\Parish;
use App\Entity\Source;
use App\Form\Partial\DatedType;
use App\Form\Partial\NotesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Inventory form.
 */
class InventoryType extends AbstractType {
    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('parish', Select2EntityType::class, [
            'label' => 'Parish',
            'required' => true,
            'class' => Parish::class,
            'remote_route' => 'parish_typeahead',
            'attr' => [
                'help_block' => '',
                'add_path' => 'parish_new_popup',
                'add_label' => 'Add Parish',
            ],
        ]);
        $builder->add('source', Select2EntityType::class, [
            'label' => 'Source',
            'required' => true,
            'class' => Source::class,
            'remote_route' => 'source_typeahead',
            'attr' => [
                'help_block' => '',
                'add_path' => 'source_new_popup',
                'add_label' => 'Add Source',
            ],
        ]);

        $builder->add('pageNumber', IntegerType::class, [
            'label' => 'pageNumber',
            'required' => false,
            'attr' => [
                'help_block' => '',
            ],
        ]);

        $builder->add('monarch', Select2EntityType::class, [
            'label' => 'Monarch',
            'required' => false,
            'class' => Monarch::class,
            'remote_route' => 'monarch_typeahead',
            'attr' => [
                'help_block' => '',
                'add_path' => 'monarch_new_popup',
                'add_label' => 'Add Monarch',
            ],
        ]);

        $builder->add('books', Select2EntityType::class, [
            'label' => 'Books',
            'multiple' => true,
            'remote_route' => 'book_typeahead',
            'class' => Book::class,
            'page_limit' => 10,
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'book_new_popup',
                'add_label' => 'Add Book',
            ],
        ]);

        DatedType::buildForm($builder, $options);
        $builder->add('transcription', TextareaType::class, [
            'label' => 'Transcription',
            'required' => true,
            'attr' => [
                'help_block' => '',
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('modifications', TextareaType::class, [
            'label' => 'Modern English',
            'attr' => [
                'help_block' => '',
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('description', TextareaType::class, [
            'label' => 'Notes',
            'required' => false,
            'attr' => [
                'help_block' => 'Public notes about the item.',
                'class' => 'tinymce',
            ],
        ]);
        NotesType::add($builder, $options);
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     */
    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefaults([
            'data_class' => Inventory::class,
        ]);
    }
}
