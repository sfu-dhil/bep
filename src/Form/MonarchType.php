<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Monarch;

use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Monarch form.
 */
class MonarchType extends TermType {
    /**
     * Add form fields to $builder.
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void {
        parent::buildForm($builder, $options);
        $builder->add('startDate', TextType::class, [
            'label' => 'Start Date',
            'required' => true,
            'help' => 'Enter the date or earliest possible date.',
            'attr' => [
                'placeholder' => 'yyyy-mm-dd',
            ],
        ]);
        $builder->add('endDate', TextType::class, [
            'label' => 'End Date',
            'required' => true,
            'help' => 'Enter the latest possible date if the date is uncertain.',
            'attr' => [
                'placeholder' => 'yyyy-mm-dd',
            ],
        ]);
    }

    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     */
    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefaults([
            'data_class' => Monarch::class,
        ]);
    }
}
