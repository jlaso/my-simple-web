<?php

namespace app\models\core\Form;

class FormBase
    implements FormBaseInterface
{
    /** @var array */
    private $fields;

    /**
     * al crear el objeto inicializa el array interno
     */
    public function __construct()
    {
        $this->fields = array();
    }

    /**
     *
     * Agrega el campo pasado como argumento
     * integra la interface fluida de tal manera que se pueden encadenar las llamadas
     *
     * @param $field
     * @param  null     $type
     * @param  null     $widget
     * @return FormBase
     *
     */
    public function add($field,$type,$widget=array())
    {
        $this->fields[] = array(
            'field'     => $field,
            'type'      => $type,
            'widget'    => $widget,
        );

        return $this;
    }

    /**
     *
     * termina la cadena devolviendo el array interno
     *
     * @return array
     *
     */
    public function end()
    {
        return $this->fields;
    }

}
