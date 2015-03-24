<?php

class Validate
{

    public static function email($email)
    {
        return preg_match("|^([\w\.-]{1,64}@[\w\.-]{1,252}\.\w{2,4})$|i", $email);
    }

    public static function int($int)
    {
        return ((string) intval($int) == $int);
    }

    /**
     * Return message "$field can't leave blank", translated
     *
     * @param string $field
     *
     * @return string
     */
    public static function cantLeaveBlank($field)
    {
        return sprintf(_('%s can\'t leave blank'),$field);
    }

}
