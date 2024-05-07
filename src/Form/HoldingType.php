<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Archive;
use App\Entity\Book;
use App\Entity\Holding;
use App\Entity\Parish;
use App\Form\Partial\DatedType;
use App\Form\Partial\NotesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Holding form.
 */
class HoldingType extends AbstractType {
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
        $builder->add('archive', Select2EntityType::class, [
            'label' => 'Archive',
            'required' => true,
            'class' => Archive::class,
            'remote_route' => 'archive_typeahead',
            'attr' => [
                'add_path' => 'archive_new',
                'add_label' => 'Add Archive',
            ],
        ]);

        $builder->add('books', Select2EntityType::class, [
            'label' => 'Books',
            'required' => true,
            'class' => Book::class,
            'remote_route' => 'book_typeahead',
            'allow_clear' => true,
            'multiple' => true,
            'attr' => [
                'add_path' => 'book_new',
                'add_label' => 'Add Book',
            ],
        ]);
        $builder->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => true,
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);
        NotesType::add($builder, $options);
        DatedType::buildForm($builder, $options);
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     */
    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefaults([
            'data_class' => Holding::class,
        ]);
    }
}
