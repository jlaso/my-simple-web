<?php

namespace lib;

//use \Slim\Views\TwigExtension;
use Twig_Function_Function;

class TwigViewSlim extends \Twig_Extension
{
    public function getName()
    {
        return 'slim';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('var_dump', 'var_dump'),
            new \Twig_SimpleFunction('sprintf','sprintf'),
            new \Twig_SimpleFunction('urlFor',array($this, 'urlFor')),
            new \Twig_SimpleFunction('urlActual',array($this, 'urlActual')),
            new \Twig_SimpleFunction('asset',array('\lib\MyFunctions','asset')),
            new \Twig_SimpleFunction('session',array('\lib\MyFunctions','session')),
            // form widgets
            new \Twig_SimpleFunction('form_table_head',array('\app\models\core\Form\FormWidget','form_table_head'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFunction('form_table_row',array('\app\models\core\Form\FormWidget','form_table_row'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFunction('form_widget',array('\app\models\core\Form\FormWidget','form_widget'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFunction('form_search_widget',array('\app\models\core\Form\FormWidget','form_search_widget'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFunction('paginator_backend_render',array('\app\models\core\Pagination\PaginatorViewExtension','render'), array(
                'is_safe' => array('html')
            )),
            new \Twig_SimpleFunction('getAllEntities','getAllEntities'),
            new \Twig_SimpleFunction('config',array('\Entity\Config','getConfig')),
            new \Twig_SimpleFunction('langConfig',array($this, 'langConfig')),
            // i18n
            new \Twig_SimpleFunction('_','_'),
        );
    }

    public function urlFor($name, $params = array(), $appName = 'default')
    {
        return \Slim\Slim::getInstance($appName)->urlFor($name, $params);
    }

    public function urlActual($name, $params = array(), $appName = 'default')
    {
        return \Slim\Slim::getInstance($appName)->urlActual($name, $params);
    }

    public function langConfig()
    {
        return \app\config\Config::getInstance()->getLanguages();
    }

}
