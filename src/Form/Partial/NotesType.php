<?php

declare(strict_types=1);

/*
 * (c) 2021 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form\Partial;

use App\Entity\Archdeaconry;
use Nines\UtilBundle\Form\TermType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Archdeaconry form.
 */
class NotesType extends TermType {
    /**
     * Add form fields to $builder.
     */
    public static function add(FormBuilderInterface $builder, array $options) : void {
        $builder->add('notes', TextareaType::class, [
            'label' => 'Notes',
            'required' => false,
            'attr' => [
                'help_block' => 'Private notes about the item. Never shown to the public.',
                'class' => 'tinymce',
            ],
        ]);
    }
}
