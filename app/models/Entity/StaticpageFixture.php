<?php


namespace Entity;

use \app\models\core\FixturableInterface;
use Entity\Staticpage;
use \app\models\core\Registry;

class StaticpageFixture implements FixturableInterface
{
    /**
     * Creates a new item from $assocArray and inserts into DB
     *
     * @param array $assocArray
     */
    public function addNewItem($assocArray)
    {
        $item = \Entity\Staticpage::factory()->create();
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
                    'slug'      => 'about',
                    'content'   => 'About us !',
                    'title'     => 'About us'
                ))
             ->addNewItem(array(
                    'slug'      => 'private-policy',
                    'content'   => 'This is our private policy',
                    'title'     => 'Private policy'
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
        return 10;
    }

}