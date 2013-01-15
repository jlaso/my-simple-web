<?php

namespace Entity;

use app\models\core\BaseModel;
use app\models\core\SluggableInterface;
use app\models\core\ValidableInterface;
use lib\SlimFunctions;

/**
 * Class that stores articles of this web
 */
class Article
    extends BaseModel
    implements SluggableInterface, ValidableInterface
{

    /**
     * Checks that slug not exists
     *
     * @param string $slug
     * @param int $id
     * @return bool
     */
    public static function checkSlug($slug, $id = 0)
    {
        $count = self::factory()
                    ->where('slug',$slug)
                    ->where_not_equal('id',$id)
                    ->count();

        $sql = \ORM::get_last_query();

        return $count > 0;
    }

    /**
     * Validates the info
     *
     * @return array
     */
    public function validate()
    {
        $result = array();
        if(empty($this->slug)) $this->slug = $this->title;
        $this->slug = \lib\SlimFunctions::slug($this->slug);
        if (empty($this->slug)) {
            $result['slug'] = 'Slug field can\'t left blank';
        } else {
            $slugExists = self::checkSlug($this->slug,$this->id);
            if ($slugExists) {
                $result['slug'] = 'Repeated slug';
            }
        }
        if (empty($this->title)) {
            $result['title'] = 'Title field can\'t left blank';
        }
        if (empty($this->description)) {
            $result['description'] = 'Description field can\'t left blank';
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
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }

}
