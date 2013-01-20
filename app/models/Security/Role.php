<?php

namespace Security;

use app\models\core\BaseModel;

class Role extends BaseModel
{

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
  `role`    varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE={$options['engine']} DEFAULT CHARSET={$options['charset']} AUTO_INCREMENT=1 ;

EOD;

    }

    /**
     * Checks if the $rol is in $roles or precedence permits the same as $role
     *
     * @param array $roles
     * @param string $rol
     *
     * @return bool
     */
    public static function can($roles, $rol)
    {
        if ($rol == 'super_admin') return true;

        if (in_array($rol,$roles)) return true;

        $parts = explode("_",$rol);
        $perm  = $parts[2];
        $ent   = $parts[1];
        $pre   = $parts[0];

        if (($perm == 'list') && in_array("{$pre}_{$ent}_show")) return true;

        if (($rol == 'admin') && (in_array($perm,array('list','show','edit')))) return true;

        return  false;
    }

}
