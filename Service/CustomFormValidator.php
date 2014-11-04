<?php
namespace Arkulpa\Bundle\SymfonyExtensionsBundle\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;

class CustomFormValidator
{

    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function bindAndValidate(Form $form, Request $request)
    {
        $form->submit($request);

        if (!$form->isValid()) {
            return $this->getErrorMessages($form);
        }
        return null;
    }

    public function customBindAndValidate(Form $form, Request $request)
    {
        $formData = array();
        /**
         * @var $child Form
         */
        foreach ($form->all() as $child) {
            //required for repeated fields
            if (count($child->all()) > 0) {
                foreach ($child->all() as $c) {
                    $formData[$child->getName()][$c->getName()] = $request->get($c->getName());
                }
            } else {
                $formData[$child->getName()] = $request->get($child->getName());
            }
        }
        if ($form->getConfig()->getOption('csrf_protection')) {
            $formData['_token'] = $request->get('_token');
        }

        $form->submit($formData);

        if (!$form->isValid()) {
            return $this->getErrorMessages($form);
        }
        return null;
    }

    public function getErrorMessages(Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $err) {
            $error = new \stdClass();
            $error->id = $form->getName();
            $error->message = $this->translator->trans($err->getMessage());
            $errors[] = $error;
        }

        foreach ($form->all() as $child) {
            if (!$child->isvalid()) {
                $errors = array_merge($errors, $this->getErrorMessages($child));
            }
        }
        return $errors;
    }
}
