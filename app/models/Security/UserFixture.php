<?php


namespace Security;

use \app\models\core\FixturableInterface;
use \Security\User;
use \app\models\core\Registry;

class UserFixture implements FixturableInterface
{

    /**
     * Creates a new Item from $roleAssocArray and inserts into DB
     *
     * @param array $assocArray
     */
    public function addNewItem($assocArray)
    {
        $user = \Security\User::factory()->create();
        foreach ($assocArray as $field=>$value) {
            $user->set($field,$value);
        }
        $user->save();
        return $user;
    }

    /**
     * Generate fixtures
     *
     * @return void
     */
    public function generateFixtures(Registry $fixturesRegistry)
    {
        $fixturesRegistry->set('user_admin',$this->addNewItem(array(
            'email' => 'admin',
            'pass'  => md5('admin'),
        )));
        $fixturesRegistry->set('user_user',$this->addNewItem(array(
            'email' => 'user',
            'pass'  => md5('user'),
        )));

    }

    /**
     * Get the order of fixture generation
     *
     * @return int
     */
    public static function getOrder()
    {
        return 1;
    }

}