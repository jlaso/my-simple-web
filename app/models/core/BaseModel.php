<?php

namespace app\models\core;

use \Model;
use app\models\core\BindableInterface;
use app\models\core\Form\FormListTypeInterface;

/**
 * Extends Model from ORM
 *
 * The ORM uses magic __get and __set to map properties to table fields, for that
 * I have named my other methods with underscore to permit use that names for fields
 *
 */
abstract class BaseModel
    extends Model
    implements BindableInterface
{

    public static $_table_use_short_name = false;
    public static $_table;

    /**
     * Factory from extended class
     *
     * that permits this
     *   Entity::factory()->...
     * or
     *   BaseModel::factory('Entity')->...
     *
     * @param string $class
     *
     * @return \ORMWrapper
     *
     */
    public static function factory($class="")
    {
        if (!$class) {
            $class = get_called_class();
        }
        static::$_table = static::_tableNameForClass($class);

        return parent::factory($class);
    }

    /**
     * @param string $class
     *
     * @return BaseModel
     */
    public static function create($class="")
    {
        if (!$class) {
            $class = get_called_class();
        }

        return parent::factory($class)->create();
    }

    /**
     * Bind entity data fields, post form for example
     *
     * @param array $array
     *
     * @internal param $assoc -array $array
     * @return mixed|void
     */
    public function bind(array $array)
    {
        $ent         = get_called_class();
        $frmLstClass = "\\{$ent}FormType";
        if (class_exists($frmLstClass)) {
            /** @var FormListTypeInterface $formList */
            $formList   = new $frmLstClass;
            foreach ($formList->getForm() as $formItem) {
                $field  = $formItem['field'];
                $type   = strtolower($formItem['type']);
                $ro     = isset($formItem['widget']['readonly']) && $formItem['widget']['readonly'];
                // only bind not readonly fields
                if (!$ro && in_array($type,array('text','textarea','number','hidden',))) {
                    $value = isset($array[$field]) ? $array[$field] : null;
                    if ( null !== $value ) {
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

    /**
     * get default create options
     *
     * @return array
     */
    public static function _defaultCreateOptions()
    {
        return array(
            'engine'  => "InnoDB",
            'charset' => "latin1"
        );
    }

    /**
     * Get the table name that corresponds to class name in the actual namespace system
     *
     * @param string $class
     * @return string
     */
    public static function _tableNameForClass($class = null)
    {
        if(!$class){
            $class = get_called_class();
        }
        // CamelCase to undescore_case
        $class = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1_', $class));
        // table name equals to PSR0 of class name
        return str_replace("\\","_",strtolower($class));
    }

    /**
     * Get the pretty name of the model
     */
    public static function _entityName()
    {

        $class = \lib\MyFunctions::camelCaseToUnderscored(get_called_class());
        $array = explode("\\",$class);
        array_shift($array);
        return implode("",$array);

    }

    /**
     * Get relations
     *
     * @return array
     */
    public function _relations()
    {
        return array();
    }

    /**
     * Get name of entity in singular
     *
     * @return string
     */
    public static function _nameSingular()
    {
        return _('BaseModel');
    }

    /**
     * Get name of entity in plural
     *
     * @return string
     */
    public static function _namePlural()
    {
        return _('BaseModels');
    }


    /**
     * Get name of entity
     *
     * @return string
     */
    public static function _nameEntity()
    {
        $str = \lib\MyFunctions::camelCaseToUnderscored(get_called_class());
        return str_replace('\\','_',$str);
    }

}
