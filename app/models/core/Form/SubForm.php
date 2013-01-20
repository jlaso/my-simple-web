<?php

namespace app\models\core\Form;

class SubForm implements SubFormInterface
{

    private $form;

    public function __construct($form)
    {
        $this->form = $form;
    }


    public function getForm()
    {
        return $this->form;
    }

}