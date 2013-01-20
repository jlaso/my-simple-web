<?php


namespace app\models\core\Form;


interface FormFilterInterface
{


    function __construct(array $options = array());

    function filter($subject);


}