<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use App\Entity\Book;
use App\Entity\Parish;
use App\Entity\Transaction;
use App\Entity\TransactionCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
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
            'label' => 'Pounds',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('s', NumberType::class, [
            'label' => 'Shillings',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('d',NumberType::class, [
            'label' => 'Pence',
            'scale' => 0,
            'required' => false,
            'mapped' => false,
        ]);
        $builder->add('copies', NumberType::class, [
            'label' => 'Copies',
            'required' => true,
            'empty_data' => 1,
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

        $builder->add('transactionCategory', Select2EntityType::class, [
            'label' => 'Category',
            'class' => TransactionCategory::class,
            'remote_route' => 'transaction_category_typeahead',
            'allow_clear' => true,
            'attr' => [
                'help_block' => '',
                'add_path' => 'transaction_category_new_popup',
                'add_label' => 'Add Category',
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
