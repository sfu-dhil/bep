<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Form\Mapper;

use App\Entity\Transaction;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Symfony\Component\Form\FormInterface;
use Traversable;

class LsdMapper extends PropertyPathMapper implements DataMapperInterface {
    public function mapDataToForms($viewData, $forms) : void {
        if (null === $viewData) {
            return;
        }
        if ( ! $viewData instanceof Transaction) {
            throw new UnexpectedTypeException($viewData, Transaction::class);
        }

        parent::mapDataToForms($viewData, $forms);
        list($l, $s, $d) = $viewData->getValue(true, true);

        /** @var FormInterface[] $formData */
        $formData = iterator_to_array($forms);
        $formData['l']->setData($l);
        $formData['s']->setData($s);
        $formData['d']->setData($d);
    }

    /**
     * @param FormInterface[]|Traversable $forms
     * @param Transaction $viewData
     */
    public function mapFormsToData($forms, &$viewData) : void {
        parent::mapFormsToData($forms, $viewData);

        /** @var FormInterface[] $formData */
        $formData = iterator_to_array($forms);

        $l = (int) $formData['l']->getData();
        $s = (int) $formData['s']->getData();
        $d = (int) $formData['d']->getData();

        if ( ! $l && ! $s && ! $d) {
            $viewData->setValue(null);

            return;
        }

        $viewData->setLsd($l, $s, $d);
    }
}
