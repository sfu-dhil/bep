<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Archdeaconry;
use App\Entity\Diocese;
use App\Entity\Injunction;

use App\Entity\Monarch;
use App\Entity\Nation;
use App\Entity\Province;
use App\Form\Partial\NotesType;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Injunction form.
 */
class InjunctionType extends AbstractType {
    public function __construct(
        private LinkableMapper $mapper,
    ) {}

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('title', TextType::class, [
            'label' => 'Title',
            'required' => true,
            'help' => 'As it appears in the ESTC',
        ]);
        $builder->add('uniformTitle', TextareaType::class, [
            'label' => 'Uniform Title',
            'required' => false,
            'attr' => [
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
            'help' => "Year, followed by the title in modern English. Eg. '1631, A thanksgiving, and prayer for the safe child bearing of the queen's majesty'. Also add any other variant titles listed in the ESTC.",
            'attr' => [
                'class' => 'collection collection-simple',
            ],
        ]);
        $builder->add('author', TextType::class, [
            'label' => 'Author',
            'required' => false,
        ]);
        $builder->add('imprint', TextareaType::class, [
            'label' => 'Imprint',
            'required' => false,
            'help' => 'Imprint as noted on the ESTC',
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('variantImprint', TextareaType::class, [
            'label' => 'Imprint, Modern English',
            'required' => false,
            'help' => 'Original spelling imprint and any variations of it',
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);
        $builder->add('date', TextType::class, [
            'label' => 'Date',
            'required' => false,
        ]);
        $builder->add('physicalDescription', TextareaType::class, [
            'label' => 'Physical Description',
            'required' => false,
            'help' => 'Public description of the physicality of the item.',
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);

        $builder->add('transcription', TextareaType::class, [
            'label' => 'Transcribed Excerpt',
            'required' => true,
            'help' => 'Public transcription of the item.',
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
        $builder->add('nation', Select2EntityType::class, [
            'label' => 'Nation',
            'required' => false,
            'class' => Nation::class,
            'remote_route' => 'nation_typeahead',
            'attr' => [
                'add_path' => 'nation_new',
                'add_label' => 'Add Nation',
            ],
        ]);
        $builder->add('province', Select2EntityType::class, [
            'label' => 'Province',
            'required' => false,
            'class' => Province::class,
            'remote_route' => 'province_typeahead',
            'attr' => [
                'add_path' => 'province_new',
                'add_label' => 'Add Province',
            ],
        ]);
        $builder->add('diocese', Select2EntityType::class, [
            'label' => 'Diocese',
            'required' => false,
            'class' => Diocese::class,
            'remote_route' => 'diocese_typeahead',
            'attr' => [
                'add_path' => 'diocese_new',
                'add_label' => 'Add Diocese',
            ],
        ]);
        $builder->add('archdeaconry', Select2EntityType::class, [
            'label' => 'Archdeaconry',
            'required' => false,
            'class' => Archdeaconry::class,
            'remote_route' => 'archdeaconry_typeahead',
            'attr' => [
                'add_path' => 'archdeaconry_new',
                'add_label' => 'Add Archdeaconry',
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
        $builder->add('estc', TextType::class, [
            'label' => 'ESTC',
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
            'data_class' => Injunction::class,
        ]);
    }
}
