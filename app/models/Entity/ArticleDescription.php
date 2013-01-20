<?php

namespace Entity;

use app\models\core\BaseModel;
use app\models\core\ValidableInterface;
use lib\MyFunctions;

/**
 * Class that stores articles of this web
 */
class ArticleDescription extends BaseModel
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
  `id`              bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id`      bigint(11) DEFAULT NULL,
  `description_id`  bigint(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }

}
