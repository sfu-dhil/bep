<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Archdeaconry;
use App\Entity\Parish;
use App\Entity\Town;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Parish form.
 */
class ParishType extends TermType {
    public function __construct(
        private LinkableMapper $mapper,
    ) {}

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);

        $builder->add('latitude', NumberType::class, [
            'label' => 'Latitude',
            'html5' => true,
            'input' => 'number',
            'scale' => 8,
            'required' => false,
            'attr' => [
                'step' => 'any',
            ],
        ]);
        $builder->add('longitude', NumberType::class, [
            'label' => 'Longitude',
            'html5' => true,
            'input' => 'number',
            'scale' => 8,
            'required' => false,
            'attr' => [
                'step' => 'any',
            ],
        ]);

        $builder->add('address', TextareaType::class, [
            'label' => 'Address',
            'required' => false,
            'help' => 'Enter a street address of the parish church, if known',
        ]);

        $builder->add('archdeaconry', Select2EntityType::class, [
            'label' => 'Archdeaconry',
            'class' => Archdeaconry::class,
            'remote_route' => 'archdeaconry_typeahead',
            'allow_clear' => true,
            'attr' => [
                'add_path' => 'archdeaconry_new',
                'add_label' => 'Add Archdeaconry',
            ],
        ]);

        $builder->add('town', Select2EntityType::class, [
            'label' => 'Town',
            'class' => Town::class,
            'remote_route' => 'town_typeahead',
            'allow_clear' => true,
            'required' => false,
            'help' => 'Town or Ward if in London or blank for a rural parish',
            'attr' => [
                'add_path' => 'town_new',
                'add_label' => 'Add Town',
            ],
        ]);
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
            'data_class' => Parish::class,
        ]);
    }
}
