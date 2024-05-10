<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Book;
use App\Entity\Injunction;
use App\Entity\ManuscriptSource;
use App\Entity\Monarch;
use App\Entity\Parish;
use App\Entity\PrintSource;
use App\Entity\Transaction;
use App\Entity\TransactionCategory;
use App\Form\Mapper\LsdMapper;
use App\Form\Partial\DatedType;
use App\Form\Partial\NotesType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        ]);

        $builder->add('location', TextType::class, [
            'label' => 'Location',
            'required' => false,
            'help' => 'Enter the location or parish if it is different from the parish you are working on. For example, if a book was purchased in Oxford for a London parish, enter “Oxford” or “Oxford, All Saints.”',
        ]);

        $builder->add('transcription', TextareaType::class, [
            'label' => 'Transcription',
            'required' => false,
            'help' => 'Provide a semi-diplomatic transcript of the manuscript entry',
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('modernTranscription', TextareaType::class, [
            'label' => 'Modern English',
            'required' => false,
            'help' => 'Provide a modern English equivalent of the manuscript entry',
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('publicNotes', TextareaType::class, [
            'label' => 'Public Notes',
            'required' => false,
            'help' => 'Provide any contextual or descriptive notes about the physical appearance of the entry',
            'attr' => [
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
                'add_path' => 'book_new',
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
                'add_path' => 'parish_new',
                'add_label' => 'Add Parish',
            ],
        ]);

        $builder->add('manuscriptSource', Select2EntityType::class, [
            'label' => 'Source',
            'class' => ManuscriptSource::class,
            'remote_route' => 'manuscript_source_typeahead',
            'allow_clear' => true,
            'required' => false,
            'attr' => [
                'add_path' => 'manuscript_source_new',
                'add_label' => 'Add MS Source',
            ],
        ]);
        $builder->add('printSource', Select2EntityType::class, [
            'label' => 'Source',
            'required' => false,
            'allow_clear' => true,
            'class' => PrintSource::class,
            'remote_route' => 'print_source_typeahead',
            'attr' => [
                'add_path' => 'print_source_new',
                'add_label' => 'Add Print Source',
            ],
        ]);
        $builder->add('page', TextType::class, [
            'label' => 'Page',
            'required' => false,
            'help' => 'Enter a page number (p. 5) or folio location (fo. 2 verso).',
        ]);

        $builder->add('transactionCategories', EntityType::class, [
            'label' => 'Transaction Categories',
            'expanded' => false,
            'multiple' => true,
            'class' => TransactionCategory::class,
            'choice_label' => 'label',
            'query_builder' => fn (EntityRepository $r) => $r->createQueryBuilder('c')->orderBy('c.label'),
            'attr' => [
                'class' => 'select2-simple',
                'data-theme' => 'bootstrap-5',
            ],
        ]);

        $builder->add('injunction', Select2EntityType::class, [
            'label' => 'Injunction',
            'class' => Injunction::class,
            'remote_route' => 'injunction_typeahead',
            'allow_clear' => true,
            'attr' => [
                'add_path' => 'injunction_new',
                'add_label' => 'Add Injunction',
            ],
        ]);

        $builder->add('monarch', Select2EntityType::class, [
            'label' => 'Monarch',
            'required' => false,
            'class' => Monarch::class,
            'remote_route' => 'monarch_typeahead',
            'attr' => [
                'add_path' => 'monarch_new',
                'add_label' => 'Add Monarch',
            ],
        ]);

        $builder->setDataMapper(new LsdMapper());
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
