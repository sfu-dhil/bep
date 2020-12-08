<?php


namespace App\Form\Mapper;


use App\Entity\Transaction;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Symfony\Component\Form\FormInterface;

class LsdMapper extends PropertyPathMapper implements DataMapperInterface {

    public function mapDataToForms($viewData, $forms) {
        if($viewData === null) {
            return;
        }
        if( ! $viewData instanceof Transaction) {
            throw new UnexpectedTypeException($viewData, Transaction::class);
        }

        parent::mapDataToForms($viewData, $forms);
        [$l, $s, $d] = $viewData->getValue(true, true);

        /** @var FormInterface[] $formData */
        $formData = iterator_to_array($forms);
        $formData['l']->setData($l);
        $formData['s']->setData($s);
        $formData['d']->setData($d);
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param Transaction $viewData
     */
    public function mapFormsToData($forms, &$viewData) {

        parent::mapFormsToData($forms, $viewData);

        /** @var FormInterface[] $formData */
        $formData = iterator_to_array($forms);

        $l = (int)$formData['l']->getData();
        $s = (int)$formData['s']->getData();
        $d = (int)$formData['d']->getData();

        if( ! $l && ! $s && ! $d) {
            $viewData->setValue(null);
            return;
        }

        $viewData->setLsd($l, $s, $d);
    }

}
