<?php

namespace app\models\core;

class Registry implements RegistryInterface
{

    private $vars = array();

    public function __set($key, $val) {
        $this->vars[$key] = $val;
    }

    public function __get($key) {
        return $this->vars[$key];
    }

    public function set($key, $val) {
        $this->vars[$key] = $val;
    }

    public function get($key) {
        return $this->vars[$key];
    }
}