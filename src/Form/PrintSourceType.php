<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\PrintSource;
use App\Entity\SourceCategory;

use App\Form\Partial\NotesType;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * PrintSource form.
 */
class PrintSourceType extends AbstractType {
    public function __construct(
        private LinkableMapper $mapper,
    ) {}

    /**
     * Add form fields to $builder.
     *
     * @param array<string,mixed> $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('title', TextType::class, [
            'label' => 'Title',
            'required' => true,
        ]);
        $builder->add('sourceCategory', Select2EntityType::class, [
            'label' => 'SourceCategory',
            'class' => SourceCategory::class,
            'remote_route' => 'source_category_typeahead',
            'allow_clear' => true,
            'attr' => [
                'add_path' => 'source_category_new',
                'add_label' => 'Add SourceCategory',
            ],
        ]);
        $builder->add('author', TextType::class, [
            'label' => 'Author',
            'required' => false,
        ]);
        $builder->add('date', TextType::class, [
            'label' => 'Date',
            'required' => false,
        ]);
        $builder->add('publisher', TextType::class, [
            'label' => 'Publisher',
            'required' => false,
        ]);
        NotesType::add($builder, $options);
        LinkableType::add($builder, $options);
        $builder->setDataMapper($this->mapper);
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     */
    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefaults([
            'data_class' => PrintSource::class,
        ]);
    }
}
