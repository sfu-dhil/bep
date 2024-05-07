<?php

declare(strict_types=1);

namespace App\Form\Partial;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DatedType {
    public static function buildForm(FormBuilderInterface $builder, array $options) : void {
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
            'required' => false,
            'help' => 'Enter the latest possible date if the date is uncertain.',
            'attr' => [
                'placeholder' => 'yyyy-mm-dd',
            ],
        ]);
        $builder->add('writtenDate', TextType::class, [
            'label' => 'Written Date',
            'required' => false,
            'help' => 'Transcribe the date as written.',
            'attr' => [
                'placeholder' => '',
            ],
        ]);
    }
}
