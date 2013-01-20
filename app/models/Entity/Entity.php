<?php

namespace Entity;

use app\models\core\BaseModel;

class Entity extends BaseModel
{

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
  `id`          bigint(11) NOT NULL AUTO_INCREMENT,
  `name`        varchar(100) NOT NULL,
  `title`       varchar(100) NOT NULL,
  `new`         tinyint(1) NULL,
  `delete`      tinyint(1) NULL,
  `show`        tinyint(1) NULL,
  `list`        tinyint(1) NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }

}