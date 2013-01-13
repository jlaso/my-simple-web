<?php

namespace Entity;

use app\models\core\Form\FormListTypeInterface;
use app\models\core\Form\FormListBase;
use app\models\core\Form\FormBase;

class StaticpageFormType
    implements  FormListTypeInterface
{

    /**
     *
     * list form type
     *
     * @return array
     *
     */
    public function getFormList()
    {

        $formBuilder = new FormListBase();

        return  $formBuilder
            ->add('id','text',array('label'=>'#'))
            ->add('slug', 'text')
            ->add('title', 'text', array('label'=>'Title'))
            ->end();

    }

    /**
     *
     * tipo de formulario de edición de campos
     *
     * @return array
     *
     */
    public function getForm()
    {

        $formBuilder = new FormBase();

        return $formBuilder
            ->add('id',         'p',    array(
                'readonly'=>true,
                'attr'=>array(
                    'class'=>'text-success',
                ))
        )
            ->add('slug',       'text', array('readonly'=>true))
            ->add('title',      'text', array('label'=>'Title'))
            ->add('content',    'textarea')
            ->end();

    }

}
