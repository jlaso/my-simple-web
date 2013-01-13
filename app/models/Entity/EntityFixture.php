<?php


namespace Entity;

use \app\models\core\FixturableInterface;
use \Entity\Config;
use \app\models\core\Registry;

/**
 * Configures the backend administrable entities
 */
class EntityFixture implements FixturableInterface
{
    /**
     * Creates a new item from $assocArray and inserts into DB
     *
     * @param array $assocArray
     */
    public function addNewItem($assocArray)
    {
        $item = \Entity\Entity::factory()->create();
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
                'name'      => 'entity_config',
                'title'     => 'Web page configuration',
                'new'       => false,
             ))
             ->addNewItem(array(
                'name'      => 'entity_article',
                'title'     => 'Articles',
                'new'       => true,
             ))
             ->addNewItem(array(
                'name'      => 'entity_staticpage',
                'title'     => 'Static pages of this web',
                'new'       => false,
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
        return 8;
    }

}