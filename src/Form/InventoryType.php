<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Book;
use App\Entity\Injunction;
use App\Entity\Inventory;
use App\Entity\ManuscriptSource;
use App\Entity\Monarch;
use App\Entity\Parish;
use App\Entity\PrintSource;
use App\Form\Partial\DatedType;
use App\Form\Partial\NotesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                'add_path' => 'parish_new',
                'add_label' => 'Add Parish',
            ],
        ]);
        $builder->add('manuscriptSource', Select2EntityType::class, [
            'label' => 'Manuscript Source',
            'required' => false,
            'class' => ManuscriptSource::class,
            'remote_route' => 'manuscript_source_typeahead',
            'attr' => [
                'add_path' => 'manuscript_source_new',
                'add_label' => 'Add Manuscript Source',
            ],
        ]);
        $builder->add('printSource', Select2EntityType::class, [
            'label' => 'Print Source',
            'required' => false,
            'class' => PrintSource::class,
            'remote_route' => 'print_source_typeahead',
            'attr' => [
                'add_path' => 'print_source_new',
                'add_label' => 'Add Print Source',
            ],
        ]);

        $builder->add('pageNumber', TextType::class, [
            'label' => 'Page',
            'required' => false,
            'help' => 'Enter a page number (p. 5) or folio location (fo. 2 verso).',
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

        DatedType::buildForm($builder, $options);
        $builder->add('transcription', TextareaType::class, [
            'label' => 'Transcription',
            'required' => true,
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('modifications', TextareaType::class, [
            'label' => 'Modern English',
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => false,
            'help' => 'Public notes about the item.',
            'attr' => [
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
