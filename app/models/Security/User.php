<?php

namespace Security;

use app\models\core\BaseModel;

class User extends BaseModel
{



    /**
     * Get the SQL creation sentece of this table
     *
     * @param array $options
     * @return string
     */
    public static function getCreationSchema(Array $options = array())
    {
        $class = self::getTableNameForClass(get_called_class());

        // default options
        $options = array_merge(self::getDefaultCreateOptions(),$options);

        return

            <<<EOD

CREATE TABLE IF NOT EXISTS `{$class}` (
  `id`      bigint(11) NOT NULL AUTO_INCREMENT,
  `email`   varchar(100) NOT NULL,
  `pass`    varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }

}
