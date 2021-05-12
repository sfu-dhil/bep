<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DatedType {
    public static function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('startDate', TextType::class, [
            'label' => 'Start Date',
            'required' => true,
            'attr' => [
                'placeholder' => 'yyyy-mm-dd',
                'help_block' => 'Enter the date or earliest possible date.',
            ],
        ]);
        $builder->add('endDate', TextType::class, [
            'label' => 'End Date',
            'required' => false,
            'attr' => [
                'placeholder' => 'yyyy-mm-dd',
                'help_block' => 'Enter the latest possible date if the date is uncertain.',
            ],
        ]);
    }
}
