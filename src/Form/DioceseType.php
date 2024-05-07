<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Diocese;
use App\Entity\Province;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Diocese form.
 */
class DioceseType extends TermType {
    public function __construct(
        private LinkableMapper $mapper,
    ) {}

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);

        $builder->add('province', Select2EntityType::class, [
            'label' => 'Province',
            'class' => Province::class,
            'remote_route' => 'province_typeahead',
            'allow_clear' => true,
            'attr' => [
                'add_path' => 'province_new',
                'add_label' => 'Add Province',
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
            'data_class' => Diocese::class,
        ]);
    }
}
