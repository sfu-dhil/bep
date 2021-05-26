<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\Book;
use App\Entity\Injunction;
use App\Entity\Parish;
use App\Entity\Source;
use App\Entity\Transaction;
use App\Entity\TransactionCategory;
use App\Form\Partial\NotesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Transaction form.
 */
class TransactionType extends AbstractType {
    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        /** @var Transaction $transaction */
        $transaction = $options['data'];
        $builder->add('l', NumberType::class, [
            'label' => 'Cost Pounds',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('s', NumberType::class, [
            'label' => 'Cost Shillings',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('d', NumberType::class, [
            'label' => 'Cost Pence',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);

        $builder->add('sl', NumberType::class, [
            'label' => 'Carriage Pounds',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('ss', NumberType::class, [
            'label' => 'Carriage Shillings',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('sd', NumberType::class, [
            'label' => 'Carriage Pence',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);

        DatedType::buildForm($builder, $options);

        $builder->add('copies', NumberType::class, [
            'label' => 'Copies',
            'required' => false,
            'attr' => [
                'help_block' => '',
            ],
        ]);

        $builder->add('location', TextType::class, [
            'label' => 'Location',
            'required' => false,
            'attr' => [
                'help_block' => 'Enter the location of the transaction, if known. Optionally include details of the location in the Description field.',
            ],
        ]);

        $builder->add('transcription', TextareaType::class, [
            'label' => 'Transcription',
            'required' => false,
            'attr' => [
                'help_block' => 'Provide a semi-diplomatic transcript of the manuscript entry',
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('description', TextareaType::class, [
            'label' => 'Modern English',
            'required' => false,
            'attr' => [
                'help_block' => 'Provide a modern English equivalent of the manuscript entry',
                'class' => 'tinymce',
            ],
        ]);
        NotesType::add($builder, $options);

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

        $builder->add('parish', Select2EntityType::class, [
            'label' => 'Parish',
            'class' => Parish::class,
            'remote_route' => 'parish_typeahead',
            'allow_clear' => false,
            'required' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'parish_new_popup',
                'add_label' => 'Add Parish',
            ],
        ]);

        $builder->add('source', Select2EntityType::class, [
            'label' => 'Source',
            'class' => Source::class,
            'remote_route' => 'source_typeahead',
            'allow_clear' => false,
            'required' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'source_new_popup',
                'add_label' => 'Add Source',
            ],
        ]);
        $builder->add('page', TextType::class, [
            'label' => 'Page',
            'required' => false,
            'attr' => [
                'help_block' => 'Enter a page number (p. 5) or folio location (f. 5 r. col. a)',
            ],
        ]);

        $builder->add('transactionCategory', Select2EntityType::class, [
            'label' => 'Transaction Category',
            'class' => TransactionCategory::class,
            'remote_route' => 'transaction_category_typeahead',
            'allow_clear' => false,
            'required' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'transaction_category_new_popup',
                'add_label' => 'Add TransactionCategory',
            ],
        ]);

        $builder->add('injunction', Select2EntityType::class, [
            'label' => 'Injunction',
            'class' => Injunction::class,
            'remote_route' => 'injunction_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'injunction_new_popup',
                'add_label' => 'Add Injunction',
            ],
        ]);

        $builder->setDataMapper(new Mapper\LsdMapper());
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     */
    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
