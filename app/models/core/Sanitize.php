<?php

namespace app\models\core;

class Sanitize
{

    public static function int($int)
    {
        return intval($int);
    }

    /**
     * sanea un email
     * @param $email
     * @return string
     */
    public static function email($email)
    {
        $email = strtolower(trim($email));
        $email = preg_replace("/[^a-z0-9\.\@]/","",$email);

        return $email;
    }

    /**
     * Sanea una cadena
     * @param  string $str
     * @return string
     */
    public static function string($str, $filter=FILTER_SANITIZE_STRING)
    {
        $result = array ('str' => trim($str) );
        filter_var_array(
            $result,
            array('str' => array(
                'filter' => $filter,
                'flags'  => !FILTER_FLAG_STRIP_LOW
            )
            )
        );

        return htmlentities($result['str'], ENT_NOQUOTES);
    }

}
