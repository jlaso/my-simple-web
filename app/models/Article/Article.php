<?php


use app\models\core\BaseModel;
use app\models\core\SluggableInterface;
use app\models\core\ValidableInterface;
use lib\SlimFunctions;

class Article
    extends BaseModel
    implements SluggableInterface, ValidableInterface
{

    public static function checkSlug($slug, $id = 0)
    {
        $count = self::factory()
                    ->where('slug',$slug)
                    ->where_not_equal('id',$id)
                    ->count();

        $sql = ORM::get_last_query();

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
                $result['slug'] = 'Repeated slug';
            }
        }
        if (empty($this->title)) {
            $result['title'] = 'Title field can\'t left blank';
        }
        if (empty($this->descripcion)) {
            $result['description'] = 'Description field can\'t left blank';
        }

        return $result;
    }

}
