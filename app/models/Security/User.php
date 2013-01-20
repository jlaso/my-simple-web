<?php

namespace Security;

use app\models\core\BaseModel;

class User extends BaseModel
{

    private $roles = null;


    /**
     * Get the SQL creation sentece of this table
     *
     * @param array $options
     * @return string
     */
    public static function _creationSchema(Array $options = array())
    {
        $class = self::_tableNameForClass(get_called_class());

        // default options
        $options = array_merge(self::_defaultCreateOptions(),$options);

        return

            <<<EOD

CREATE TABLE IF NOT EXISTS `{$class}` (
  `id`      bigint(11) NOT NULL AUTO_INCREMENT,
  `email`   varchar(100) NOT NULL,
  `pass`    varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }


    /**
     * Get the roles have the user
     *
     * @return array
     */

    public function getRoles()
    {
        if (null === $this->roles) {

            $sql = sprintf("SELECT *
                            FROM `security_role`
                            WHERE `id` IN
                                (SELECT `id`
                                 FROM `security_role_user`
                                 WHERE `user_id` = '%d'    )"
                         ,$this->id);

            $roles = RoleUser::factory()->raw_query($sql);

            $this->roles = array();
            foreach ($roles as $role) {
                $this->roles[] = $role->name;
            }

        }

        return $this->roles;
    }


    /**
     * Test if user can ... $rol
     *
     * @param string $rol
     *
     * @return bool
     */
    public function can($rol)
    {
        // first, get user's roles
        $roles = $this->getRoles();
        // and test if can ... $rol
        return Role::can($roles,$rol);

    }

    /**
     * Goody for find_one
     *
     * @param int $id
     *
     * @return \ORM
     */
    public static function getUser($id)
    {
        return User::factory()->find_one($id);
    }

}
