<?php

namespace app\models\Contact;

use app\models\core\Form\FormListTypeInterface;
use app\models\core\Form\FormListBase;
use app\models\core\Form\FormBase;
use app\models\core\Form\FormSearchTypeInterface;

class ContactFormType
    implements  FormListTypeInterface, FormSearchTypeInterface
{

    /**
     * form list type
     *
     * @return array
     */
    public function getFormList()
    {

        $formBuilder = new FormListBase();

        return  $formBuilder
            ->add('id',         'text',     array(
                                                'label'=>'#',
                                                'attr' =>array(
                                                    'class'=>'badge',
                                                ),
                                            ))
            ->add('created_at',
                                'date',     array('label'=>'Created At'))
            ->add('email',      'text',     array('label'=>'Email'))
            ->add('phone',      'text',     array('label'=>'Phone'))
            ->add('pending',    'boolean',  array(
                                                'label'=> ' ?',
                                                'attr' => array(
                                                    'class' => 'span1',
                                                ),
                                            ))
            ->end();

    }

    /**
     * edit form type
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
            ->add('message','textarea')
            ->end();

    }


    /**
     * search form type
     *
     * @return array
     */
    public function getSearchForm()
    {

        $formBuilder = new FormBase();

        return $formBuilder
            ->add('message','text',         array(
                                                'label' => 'Texto',
                                                'op'    => 'like',
                                            )
            )
            ->end();

    }

}
