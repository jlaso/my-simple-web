<?php


namespace Security;

use \app\models\core\FixturableInterface;
use \Security\User;
use \app\models\core\Registry;

class UserFixture implements FixturableInterface
{
    /**
     * Generate fixtures
     *
     * @return void
     */
    public function generateFixtures(Registry $fixturesRegistry)
    {
        $user = \Security\User::factory()->create();
        $user->email = 'admin';
        $user->pass = md5('admin');
        $user->save();
        $fixturesRegistry->set('user_admin',$user);

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