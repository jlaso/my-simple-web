<?php


namespace Entity;

use \app\models\core\FixturableInterface;
use \Entity\Config;
use \app\models\core\Registry;

class ConfigFixture implements FixturableInterface
{
    /**
     * Creates a new item from $assocArray and inserts into DB
     *
     * @param array $assocArray
     */
    public function addNewItem($assocArray)
    {
        $item = \Entity\Config::factory()->create();
        foreach ($assocArray as $field=>$value) {
            $item->set($field,$value);
        }
        $item->save();
        return $this;
    }

    /**
     * Generate fixtures
     *
     * @return void
     */
    public function generateFixtures(Registry $fixturesRegistry)
    {
        $this->addNewItem(array(
                'slug'      => 'web.title',
                'value'     => 'My simple page',
             ))
             ->addNewItem(array(
                'slug'      => 'web.keywords',
                'value'     => 'webdesign,webdevelop,internet development,jaitec,web design, web development',
             ))
             ->addNewItem(array(
                'slug'      => 'web.description',
                'value'     => 'Can make the web development very very simple',
             ))
        ;

    }

    /**
     * Get the order of fixture generation
     *
     * @return int
     */
    public static function getOrder()
    {
        return 9;
    }

}