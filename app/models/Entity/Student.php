<?php

namespace Entity;

use app\models\core\BaseModel;

/**
 * Class that stores students of this web
 */
class Student extends BaseModel
{

    public static $_table = 'test.student';

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} AUTO_INCREMENT=1 DEFAULT CHARSET={$options['charset']};

EOD;

    }

}
