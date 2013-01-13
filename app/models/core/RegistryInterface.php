<?php

namespace app\models\core;

interface RegistryInterface
{

    public function set($key, $val);

    public function get($key);

}