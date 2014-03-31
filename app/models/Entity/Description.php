<?php

namespace Entity;

use app\models\core\BaseModel;
use app\models\core\ValidableInterface;
use lib\MyFunctions;
use Validate;


/**
 * Class that stores articles of this web
 */
class Description
    extends BaseModel
    implements ValidableInterface
{

    /**
     * Validates the info
     *
     * @return array
     */
    public function validate()
    {
        $result = array();
        if (empty($this->lang)) {
            $result['lang'] = Validate::cantLeaveBlank(_('Lang'));
        }
        if (empty($this->content)) {
            $result['content'] = Validate::cantLeaveBlank(_('Content'));
        }

        return $result;
    }

    /**
     * Get the SQL creation sentece of this table
     *
     * @param array $options
     * @return string
     */
    public static function _creationSchema(Array $options = array())
    {
        $class = self::_tableNameForClass(get_called_class());

        // default options
        $options = array_merge(self::_defaultCreateOptions(),$options);

        return

            <<<EOD

CREATE TABLE IF NOT EXISTS `{$class}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(8) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }
    /**
     * Get name of entity in singular
     *
     * @return string
     */
    public static function _nameSingular()
    {
        return _('Description');
    }

    /**
     * Get name of entity in plural
     *
     * @return string
     */
    public static function _namePlural()
    {
        return _('Descriptions');
    }



}
