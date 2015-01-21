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
            $item->set($field,is_bool($value) ? (int) $value : $value);
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
        // declares the entities that are available for backend
        $entities = array(
            array(
                'name'      => 'entity_config',
                'title'     => 'Web page configuration',
                'new'       => false,
                'delete'    => false,
                'list'      => true,
                'show'      => true,
            ),
            array(
                'name'      => 'entity_article',
                'title'     => 'Articles',
                'new'       => true,
                'delete'    => true,
                'list'      => true,
                'show'      => true,
            ),
            array(
                'name'      => 'entity_staticpage',
                'title'     => 'Static pages of this web',
                'new'       => false,
                'delete'    => false,
                'list'      => true,
                'show'      => true,
            )
        );
        // put info into fixtures registry, so are available for other fixture process
        $fixturesRegistry->set('entities',$entities);
        // put info into DB
        foreach ($entities as $entity) {
            $this->addNewItem($entity);
        }

    }

    /**
     * Get the order of fixture generation
     *
     * @return int
     */
    public static function getOrder()
    {
        return 0;
    }

}