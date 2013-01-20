<?php


namespace app\models\core\Form;


abstract class BaseFormFilter implements  FormFilterInterface
{

    // options for filter
    protected $options;

    /**
     * Injects filter options in constructor
     *
     * @param array $options
     */
    function __construct(array $options = array())
    {
        $this->options = $options;
    }


    /**
     * To stablish default options in extended classes
     *
     * @param array $options
     */
    function setDefaultOptions(array $options)
    {
        $this->options = array_merge($options,$this->options);
    }

    /**
     * Sample filter that do nothing
     *
     * @return mixed
     */
    function filter($subject)
    {
        return $subject;
    }


}