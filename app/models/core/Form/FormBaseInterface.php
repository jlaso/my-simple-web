<?php

namespace app\models\core\Form;

interface FormBaseInterface
{

    public function __construct();

    public function add($field,$type,$widget=array());

    public function end();

}
