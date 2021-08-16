<?php

namespace models\forms\base;

use models\forms\settings\Contract;

class FormCollection extends Form
{

    /**
     * @var Contract[]
     */
    protected $forms;

    /**
     * @param Form $form
     * @return $this
     */
    public function addForm(Form $form)
    {
        $this->forms[get_class($form)] = $form;
        return $this;
    }

    /**
     * @param string $formClass
     * @return Contract|Form|null
     */
    public function getForm($formClass)
    {
        return $this->forms[$formClass] ?? null;
    }

    public function load($data, $formName = null)
    {
        /** @var Form $form */
        foreach ($this->getForms() as $form) {
            $form->load($data);
        }
    }

    /**
     * @return Form[]|Contract[]
     */
    public function getForms(): array
    {
        return $this->forms;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $valid = true;
        /** @var Form $form */
        foreach ($this->getForms() as $form) {
            $valid = $valid && $form->validate($attributeNames, $clearErrors);
        }
        return $valid;
    }

    public function getErrorsAsString($prefix = "")
    {
        $errors = '';
        /** @var Form $form */
        foreach ($this->getForms() as $form) {
            $errors .= $form->getErrorsAsString(get_class($form) . ":\n");
        }
        return $errors;
    }
}