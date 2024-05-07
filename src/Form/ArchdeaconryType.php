<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Archdeaconry;
use App\Entity\Diocese;
use Nines\MediaBundle\Form\LinkableType;
use Nines\MediaBundle\Form\Mapper\LinkableMapper;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Archdeaconry form.
 */
class ArchdeaconryType extends TermType {
    public function __construct(
        private LinkableMapper $mapper,
    ) {}

    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);
        $builder->add('diocese', Select2EntityType::class, [
            'label' => 'Diocese',
            'class' => Diocese::class,
            'remote_route' => 'diocese_typeahead',
            'allow_clear' => true,
            'attr' => [
                'add_path' => 'diocese_new',
                'add_label' => 'Add Diocese',
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
            'data_class' => Archdeaconry::class,
        ]);
    }
}
