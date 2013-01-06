<?php

namespace app\models\Article;

use app\models\core\Form\FormListTypeInterface;
use app\models\core\Form\FormListBase;
use app\models\core\Form\FormBase;
use app\models\core\Form\FormSearchTypeInterface;

class ArticleFormType
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

        $formBuilder = new FormBase();

        return $formBuilder
                    ->add('id',         'p',    array(
                                                'readonly'=>true,
                                                'attr'=>array(
                                                    'class'=>'text-success',
                                                 ))
                    )
                    ->add('slug',       'text', array('readonly'=>true))
                    ->add('titulo',     'text', array('label'=>'Title'))
                    ->add('description','textarea')
                    ->add('video',      'textarea',array(
                                                    'label'=>'Video (src atribute)',
                                                    'attr' => array(
                                                        'class' => 'span6',
                                                    ),
                                                ))
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
