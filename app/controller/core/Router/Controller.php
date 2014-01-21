<?php

namespace Router;

use \Slim\Slim;

class Controller
{
    /** @var SlimExt */
    protected $slimInstance;

    function __construct()
    {
        $this->slimInstance = Slim::getInstance();
    }

    public static function __callStatic($name, $arguments)
    {
        $calledClass = get_called_class();
        $obj         = new $calledClass;
        $name        = preg_replace('/^___/','',$name);
        call_user_func_array(array($obj, $name), $arguments);
    }

    protected function getSlim()
    {
        return $this->slimInstance;
    }

}
