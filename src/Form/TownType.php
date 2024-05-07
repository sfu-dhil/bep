<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\County;
use App\Entity\Town;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Town form.
 */
class TownType extends TermType {
    public function __construct(
        private LinkableMapper $mapper,
    ) {}

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);

        $builder->add('inLondon', ChoiceType::class, [
            'label' => 'In London',
            'expanded' => true,
            'multiple' => false,
            'choices' => [
                'Yes' => true,
                'No' => false,
            ],
            'required' => true,
            'help' => 'Yes if this is a Ward in the City of London',
        ]);

        $builder->add('county', Select2EntityType::class, [
            'label' => 'County',
            'class' => County::class,
            'remote_route' => 'county_typeahead',
            'allow_clear' => true,
            'attr' => [
                'add_path' => 'county_new',
                'add_label' => 'Add County',
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
            'data_class' => Town::class,
        ]);
    }
}
