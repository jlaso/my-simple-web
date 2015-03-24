<?php

namespace lib;

use \Slim\Extras\Views\Twig;
use Twig_Function_Function;

class TwigViewSlim extends Twig
{
    private function addFunctions(\Twig_Environment $twigEnvironment)
    {
        $twigEnvironment->addFunction('var_dump',
                new Twig_Function_Function('var_dump'));
        $twigEnvironment->addFunction('sprintf',
            new Twig_Function_Function('sprintf'));
        $twigEnvironment->addFunction('urlFor',
                new Twig_Function_Function('\Router\SlimExt::getInstance()->urlFor'));
        $twigEnvironment->addFunction('urlActual',
            new Twig_Function_Function('\Router\SlimExt::getInstance()->urlActual'));
        $twigEnvironment->addFunction('asset',
                new Twig_Function_Function('\lib\MyFunctions::asset'));
        $twigEnvironment->addFunction('session',
            new Twig_Function_Function('\lib\MyFunctions::session'));

        // form widgets
        $twigEnvironment->addFunction('form_table_head',
            new Twig_Function_Function('\app\models\core\Form\FormWidget::form_table_head', array(
                'is_safe' => array('html')
            )));
        $twigEnvironment->addFunction('form_table_row',
            new Twig_Function_Function('\app\models\core\Form\FormWidget::form_table_row', array(
                'is_safe' => array('html')
            )));
        $twigEnvironment->addFunction('form_widget',
            new Twig_Function_Function('\app\models\core\Form\FormWidget::form_widget', array(
                'is_safe' => array('html')
            )));
        $twigEnvironment->addFunction('form_search_widget',
            new Twig_Function_Function('\app\models\core\Form\FormWidget::form_search_widget', array(
                'is_safe' => array('html')
            )));
        $twigEnvironment->addFunction('paginator_backend_render',
            new Twig_Function_Function('\app\models\core\Pagination\PaginatorViewExtension::render', array(
                'is_safe' => array('html')
            )));
        $twigEnvironment->addFunction('getAllEntities',
            new Twig_Function_Function('getAllEntities'));
        $twigEnvironment->addFunction('config',
            new Twig_Function_Function('\Entity\Config::getConfig'));
        $twigEnvironment->addFunction('langConfig',
            new Twig_Function_Function('\app\config\Config::getInstance()->getLanguages'));
        // i18n
        $twigEnvironment->addFunction('_',
            new Twig_Function_Function('_',array(
                'is_safe' => array('html')
            )));

    }

    public function getEnvironment()
    {
        $twigEnvironment = parent::getEnvironment();
        $this->addFunctions($twigEnvironment);

        return $twigEnvironment;
    }


}
