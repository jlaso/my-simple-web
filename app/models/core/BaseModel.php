<?php

namespace app\models\core;

use Model;
use BindableInterface;

abstract class BaseModel
    extends Model
    implements BindableInterface
{

    /**
     *
     * Recrea la factoria desde el nombre de la clase hija,
     *
     * esto permite hacer un llamada como
     * EntidadHija::factory()->...
     * o
     * BaseModel::factory('EntidadHija')->...
     *
     * @param string $class
     *
     * @return \ORM|\ORMWrapper
     *
     */
    public static function factory($class="")
    {
        if (!$class) {
            $class = get_called_class();
            $class = explode("/",$class);

            return parent::factory($class[count($class)-1]);
        } else {
            return parent::factory($class);
        }
    }

    /**
     *
     * Bind de los datos pasados con los de la entidad, por ejemplo
     * cuando se reciben los parámetros por post de un formulario
     *
     * @param assoc-array $array
     *
     */
    public function bind(array $array)
    {

        $ent         = get_called_class();
        $frmLstClass = "\\app\\models\\{$ent}\\{$ent}FormType";
        if (class_exists($frmLstClass)) {
            /** @var $formList \app\models\core\Form\FormListTypeInterface */
            $formList   = new $frmLstClass;
            foreach ($formList->getForm() as $formItem) {
                $field  = $formItem['field'];
                $type   = strtolower($formItem['type']);
                $ro     = isset($formItem['widget']['readonly']) && $formItem['widget']['readonly'];
                // solo bind de aquellos input.. que no sean readonly
                if (!$ro && in_array($type,array('text','textarea','number','hidden',))) {
                    $value = isset($array[$field]) ? $array[$field] : '';
                    if ($value) {
                        $this->set($field,$value);
                    }

                }

            }
        } else {
            foreach ($array as $key=>$value) {
                $this->set($key,$value);
            }
        }
    }

}
