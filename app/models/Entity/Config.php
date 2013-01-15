<?php

namespace Entity;

use \app\models\core\BaseModel;
use \app\models\core\SluggableInterface;
use \app\models\core\ValidableInterface;
use \lib\SlimFunctions;
use \ORM;

class Config
    extends BaseModel
    implements SluggableInterface, ValidableInterface
{

    private static $instance = null;

    /**
     * Checks if slug is repeated
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
     * Validate values before save
     *
     * @return array
     */
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
                $result['slug'] = 'Repeated slug';
            }
        }
        if (empty($this->value)) {
            $result['value'] = 'Value field can\'t left blank';
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
  `value`       varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }

    /**
     * Get the value of key in the config table
     *
     * @param $key
     * @return mixed
     */
    public static function getConfig($key)
    {
        // first checks if is first time, similar to Singleton Pattern
        if (self::$instance == null) {

            self::$instance = array();
            // read all values from DB
            $configs = self::factory()->find_many();
            foreach ($configs as $config) {
                self::$instance[$config->slug] = $config->value;
            }

        }
        // checks if key exists and return it
        return (isset(self::$instance[$key]) ? self::$instance[$key] : null );
    }

}
