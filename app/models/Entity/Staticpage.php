<?php

namespace Entity;

use app\models\core\BaseModel;
use app\models\core\SluggableInterface;
use app\models\core\ValidableInterface;
use lib\SlimFunctions;

class Staticpage
    extends BaseModel
    implements SluggableInterface,ValidableInterface
{

    public static function checkSlug($slug, $id = 0)
    {
        $count = self::factory()
            ->where('slug',$slug)
            ->where_not_equal('id',$id)
            ->count();

        $sql = \ORM::get_last_query();

        return $count > 0;
    }

    public function validate()
    {
        $result = array();
        if(empty($this->slug)) $this->slug = $this->titulo;
        $this->slug = \lib\SlimFunctions::slug($this->slug);
        if (empty($this->slug)) {
            $result['slug'] = 'Slug field can\'t left blank';
        } else {
            $slugExists = self::checkSlug($this->slug,$this->id);
            if ($slugExists) {
                $result['slug'] = 'Slug repetido';
            }
        }

        return $result;
    }

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
  `id`          bigint(11) NOT NULL AUTO_INCREMENT,
  `slug`        varchar(100) NOT NULL,
  `title`       varchar(100) NOT NULL,
  `content`     text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }
}
