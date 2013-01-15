<?php

namespace Entity;

use app\models\core\Form\FormListTypeInterface;
use app\models\core\Form\FormListBase;
use app\models\core\Form\FormBase;
use app\models\core\Form\FormSearchTypeInterface;

class ConfigFormType
    implements  FormListTypeInterface, FormSearchTypeInterface
{

    /**
     * tipo de formulario de lista
     *
     * @return array
     */
    public function getFormList()
    {

        $formBuilder = new FormListBase();

        return  $formBuilder
                    ->add('id',         'text', array(
                                                    'label'=>'#',
                                                    'attr' =>array(
                                                            'class'=>'badge',
                                                            ),
                                                ))
                    ->add('slug', 'text')
                    ->add('value', 'text', array('label'=>'Value'))
                    ->end();

    }

    /**
     * tipo de formulario de edición de campos
     *
     * @return array
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
                    ->add('value',      'text', array('label'=>'Value'))
                    ->end();

    }


    /**
     * tipo de formulario de búsqueda para el backend
     *
     * @return array
     */
    public function getSearchForm()
    {

        $formBuilder = new FormBase();

        return $formBuilder
                    ->add(array('value','slug'),
                                  'text',         array(
                                                    'label' => 'Value',
                                                    'op'    => 'like',
                                                  )
                         )
                    ->end();

    }

}
