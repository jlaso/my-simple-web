<?php


namespace Entity;

use \app\models\core\FixturableInterface;
use Entity\Staticpage;
use \app\models\core\Registry;
use Validate;


class StaticpageFixture implements FixturableInterface
{
    /**
     * Creates a new item from $assocArray and inserts into DB
     *
     * @param array $assocArray
     *
     * @return $this
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
     * @param \app\models\core\Registry $fixturesRegistry
     *
     * @return void
     */
    public function generateFixtures(Registry $fixturesRegistry)
    {
        $this->addNewItem(
                array(
                    'slug'    => 'about.en',
                    'content' => 'About us !',
                    'title'   => 'About us',
                )
            )
            ->addNewItem(
                array(
                    'slug'    => 'about.es',
                    'content' => '¡ Acerca de nosotros !',
                    'title'   => 'Esto es lo que contamos sobre nosotros.',
                )
            )
            ->addNewItem(
                array(
                    'slug'    => 'privacy-policy.es',
                    'content' => 'Esta es nuestra política de privacidad',
                    'title'   => 'Política de privacidad'
                )
            )
            ->addNewItem(
                array(
                    'slug'    => 'privacy-policy.en',
                    'content' => 'This is our privacy policy',
                    'title'   => 'Privacy policy'
                )
            )
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