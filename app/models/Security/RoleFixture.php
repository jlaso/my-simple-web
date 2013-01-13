<?php


namespace Security;

use \app\models\core\FixturableInterface;
use \Security\User;
use \app\models\core\Registry;

class RoleFixture implements FixturableInterface
{
    private $registry;

    /**
     * Creates a new Role from $roleAssocArray and inserts into DB
     *
     * @param array $roleAssocArray
     */
    public function addNewRole($roleAssocArray)
    {
        $role = \Security\Role::factory()->create();
        foreach ($roleAssocArray as $field=>$value) {
            $role->set($field,$value);
        }
        $role->save();
        $this->registry->set('role_'.$role->role, $role);
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

        $this->addNewRole(array( 'role'=>'super_admin'  ))
             ->addNewRole(array( 'role'=>'admin'        ))
             ->addNewRole(array( 'role'=>'user'         ))
             ->addNewRole(array( 'role'=>'anonymous'    ))
        ;
    }

    /**
     * Get the order of fixture generation
     *
     * @return int
     */
    public static function getOrder()
    {
        return 2;
    }

}