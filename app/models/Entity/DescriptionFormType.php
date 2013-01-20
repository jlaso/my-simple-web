<?php

namespace Entity;

use app\models\core\Form\FormNewInterface;
use app\models\core\Form\FormListTypeInterface;
use app\models\core\Form\FormListBase;
use app\models\core\Form\FormBase;
use app\models\core\Form\FormSearchTypeInterface;
use app\models\core\Form\MoreFormFilter;

class DescriptionFormType
    implements  FormListTypeInterface,
                FormSearchTypeInterface,
                FormNewInterface            // can new items added from backend
{

    /**
     * Form List definition
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
                    ->add('lang', 'text')
                    ->add('content', 'text', array( 'label' =>_('Content'),
                                                    'filter'=> new MoreFormFilter(array(
                                                            'limit'=>50
                                                        ))))
                    ->end();

    }

    /**
     * Form edit
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
                    ->add('lang',       'p',    array(
                                                'readonly'=>true,
                                                'attr'=>array(
                                                    'class'=>'text-success',
                                                ))
                    )
                    ->add('content','textarea')
        /*
                    ->add('video',      'textarea',array(
                                                    'label'=>'Video (src atribute)',
                                                    'attr' => array(
                                                        'class' => 'span6',
                                                    ),
                                                ))
        */
                    ->end();

    }


    /**
     * Search Form
     *
     * @return array
     */
    public function getSearchForm()
    {

        $formBuilder = new FormBase();

        return $formBuilder
                    ->add(array('title','description'),
                                  'text',         array(
                                                    'label' => _('Text'),
                                                    'op'    => 'like',
                                                  )
                         )
                    ->end();

    }

    public static function _nameSingular()
    {
        return Description::_namePlural();
    }


    public static function _namePlural()
    {
        return Description::_namePlural();
    }

    public static function _nameEntity()
    {
        return Description::_nameEntity();
    }

}
