<?php

namespace Entity;

use app\models\core\Form\FormNewInterface;
use app\models\core\Form\FormListTypeInterface;
use app\models\core\Form\FormListBase;
use app\models\core\Form\FormBase;
use app\models\core\Form\FormSearchTypeInterface;

class ArticleFormType
    implements  FormListTypeInterface,
                FormSearchTypeInterface,
                FormNewInterface            // can new items added from backend
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
                    ->add('title', 'text', array('label'=>'Title'))
                    ->end();

    }

    /**
     * tipo de formulario de edición de campos
     *
     * @return array
     */
    public function getForm()
    {

        $subForm = new FormListBase();

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

        /*
                    ->addSubForm(
                                $subForm->add('id',     'text')
                                        ->add('lang',   'text')
                                        ->add('content','text')
                                        ->end()
                                )
        */
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
                    ->add(array('title','description'),
                                  'text',         array(
                                                    'label' => 'Text',
                                                    'op'    => 'like',
                                                  )
                         )
                    ->end();

    }

}
