<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Nation;
use App\Entity\Province;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Province form.
 */
class ProvinceType extends TermType {
    public function __construct(
        private LinkableMapper $mapper,
    ) {}

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);
        $builder->add('nation', Select2EntityType::class, [
            'label' => 'Nation',
            'class' => Nation::class,
            'remote_route' => 'nation_typeahead',
            'allow_clear' => true,
            'attr' => [
                'add_path' => 'nation_new',
                'add_label' => 'Add Nation',
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
            'data_class' => Province::class,
        ]);
    }
}
