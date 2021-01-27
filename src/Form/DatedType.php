<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

class DatedType {
    public static function buildForm(FormBuilderInterface $builder, array $options) : void {
        $builder->add('startDate', DateType::class, [
            'label' => 'Start Date',
            'required' => true,
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'attr' => [
                'help_block' => 'Enter the date or earliest possible date.',
            ],
        ]);
        $builder->add('endDate', DateType::class, [
            'label' => 'End Date',
            'required' => false,
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'attr' => [
                'help_block' => 'Enter the latest possible date if the date is uncertain.',
            ],
        ]);
    }
}
