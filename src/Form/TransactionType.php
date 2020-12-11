<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            'label' => 'Shipping Pounds',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('ss', NumberType::class, [
            'label' => 'Shipping Shillings',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('sd', NumberType::class, [
            'label' => 'Shipping Pence',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);

        $builder->add('copies', NumberType::class, [
            'label' => 'Copies',
            'required' => false,
            'attr' => [
                'help_block' => '',
            ],
        ]);
        $builder->add('transcription', TextareaType::class, [
            'label' => 'Transcription',
            'required' => false,
            'attr' => [
                'help_block' => 'Copy the transaction text as closely as possible to how it appears',
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => false,
            'attr' => [
                'help_block' => 'Provide a modern-spelling equivalent to the transaction text',
                'class' => 'tinymce',
            ],
        ]);

        $builder->add('book', Select2EntityType::class, [
            'label' => 'Book',
            'class' => Book::class,
            'remote_route' => 'book_typeahead',
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
            'allow_clear' => true,
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
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'source_new_popup',
                'add_label' => 'Add Source',
            ],
        ]);

        $builder->add('transactionCategory', Select2EntityType::class, [
            'label' => 'TransactionCategory',
            'class' => TransactionCategory::class,
            'remote_route' => 'transaction_category_typeahead',
            'allow_clear' => true,
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
