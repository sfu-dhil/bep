<?php

declare(strict_types=1);

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
            'label' => 'Private Notes',
            'required' => false,
            'help' => 'Private notes about the item. Never shown to the public.',
            'attr' => [
                'class' => 'tinymce',
            ],
        ]);
    }
}
