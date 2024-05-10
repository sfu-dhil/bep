<?php

declare(strict_types=1);

namespace App\Form\Mapper;

use App\Entity\Transaction;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\DataMapper\DataMapper;
use Symfony\Component\Form\FormInterface;
use Traversable;

class LsdMapper extends DataMapper implements DataMapperInterface {
    public function mapDataToForms(mixed $viewData, Traversable $forms) : void {
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

        list($sl, $ss, $sd) = $viewData->getShippingValue(true, true);

        $formData['sl']->setData($sl);
        $formData['ss']->setData($ss);
        $formData['sd']->setData($sd);
    }

    public function mapFormsToData(Traversable $forms, mixed &$viewData) : void {
        parent::mapFormsToData($forms, $viewData);

        /** @var FormInterface[] $formData */
        $formData = iterator_to_array($forms);

        $l = (int) $formData['l']->getData();
        $s = (int) $formData['s']->getData();
        $d = (int) $formData['d']->getData();

        if ( ! $l && ! $s && ! $d) {
            $viewData->setValue(null);
        } else {
            $viewData->setLsd($l, $s, $d);
        }

        $sl = (int) $formData['sl']->getData();
        $ss = (int) $formData['ss']->getData();
        $sd = (int) $formData['sd']->getData();

        if ( ! $sl && ! $ss && ! $sd) {
            $viewData->setShippingValue(null);
        } else {
            $viewData->setShippingLsd($sl, $ss, $sd);
        }
    }
}
