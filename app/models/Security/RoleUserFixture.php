<?php


namespace Security;

use \app\models\core\FixturableInterface;
use \Security\User;
use app\models\core\Registry;

class RoleUserFixture implements FixturableInterface
{
    private $registry;
    /**
     * Creates a new Role from $roleAssocArray and inserts into DB
     *
     * @param array $roleAssocArray
     */
    public function addNewRoleUser($assocArray)
    {
        $roleUser = \Security\RoleUser::factory()->create();
        foreach ($assocArray as $field=>$value) {
            $roleUser->set($field,$value);
        }
        $roleUser->save();
        return $this;
    }

    /**
     * Generate fixtures
     *
     * @return void
     */
    public function generateFixtures(Registry $fixturesRegistry)
    {
        $this->registry = $fixturesRegistry;

        $this->addNewRoleUser(array(
                                'role_id'=>$fixturesRegistry->get('role_super_admin')->id,
                                'user_id'=>$fixturesRegistry->get('user_admin')->id
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
        return 3;
    }

}