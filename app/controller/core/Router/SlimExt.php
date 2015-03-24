<?php


namespace Router;

use \Slim\Slim;

class SlimExt extends Slim
{
    protected static $namespacesMap = null;

    /**
     * @param array $userSettings
     */
    public function __construct(array $userSettings = array())
    {
        self::getNamespacesMap();
        return parent::__construct($userSettings);
    }

    /**
     * @return mixed
     */
    public static function getNamespacesMap()
    {
        if(!static::$namespacesMap){
            static::$namespacesMap = require (static::getRootDir() . '/vendor/composer/autoload_namespaces.php');
        };

        return static::$namespacesMap;
    }

    /**
     * @return string
     */
    public static function getRootDir()
    {
        return dirname(dirname(dirname(dirname(__DIR__))));
    }


    /**
     * Intercepts Slim mapRoute to establish the language if case
     *
     * @param $args
     *
     * @return \Slim\Route
     */
    protected function mapRoute($args)
    {
        $callable = $args[1];
        $lang     = preg_match('/:lang/',$args[0]);
        $args[1]  = function() use($callable,$lang){
            $args = func_get_args();
            //@TODO: check if lang is in language list
            if($lang && isset($args[0])) $_SESSION['lang'] = $args[0];
            call_user_func_array($callable,$args);
        };
        return parent::mapRoute($args);
    }

    /**
     * Intercept Slim urlFor to inject language if case
     *
     * @param string $name
     * @param array $params
     *
     * @return string
     */
    public function urlFor($name, $params = array())
    {
        if (!isset($params['lang'])) {
            $params['lang'] = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
        }
        return parent::urlFor($name,$params);
    }

    /**
     * Recall current route with params
     *
     * @param array $params
     *
     * @return string
     */
    public function urlActual($params = array())
    {
        $route  = $this->router()->getCurrentRoute()->getName();
        $params = array_merge($this->router()->getCurrentRoute()->getParams(),$params);
        return parent::urlFor($route,$params);
    }

    /**
     * Render a template
     *
     * Call this method within a GET, POST, PUT, DELETE, NOT FOUND, or ERROR
     * callable to render a template whose output is appended to the
     * current HTTP response body. How the template is rendered is
     * delegated to the current View.
     *
     * This hook permits to have one folder to custom templates that isn't in repository
     *
     * @param  string $template The name of the template passed into the view's render() method
     * @param  array  $data     Associative array of data made available to the view
     * @param  int    $status   The HTTP response status code to use (optional)
     */
    public function render($template, $data = array(), $status = null)
    {
        $templates = self::config('templates.path');
        $custom = 'custom/'.$template;
        $file = dirname(dirname(dirname(dirname(__DIR__)))).'/web/'.$templates.'/'.$custom;
        if (file_exists($file)) {
            $template = $custom;
        }
        parent::render($template,$data,$status);

        return;

        if (!is_null($status)) {
            $this->response->status($status);
        }

        $rootDir = static::getRootDir();
        $templateDir = $templates = self::config('templates.path');

        if(preg_match('/^@(?<name>[^:]*?):(?<path>.*?)$/', $template, $matches)){
            $map = static::getNamespacesMap();
            $name = str_replace('/', '\\', $matches['name']);
            if(isset($map[$name])){
                $prefix = (is_array($map[$name]) ? $map[$name][0] : $map[$name]) . '/' . $matches['name'] . '/templates/';
                $path = $matches['path'];
                //var_dump($rootDir . '/web/custom/' . $matches['name'] . '/' . $path, $prefix . $path); die;
                if(file_exists($rootDir . '/web/custom/' . $matches['name'] . '/' . $path)){
                    $templateDir = $rootDir . '/web/custom/' . $matches['name'] . '/';
                    $template = $path;
                }elseif(file_exists($prefix . $path)){
                    $templateDir = $prefix;
                    $template = $path;
                }else{
                    $templateDir = $templates;
                }
            }
        }else{

            $file =  $rootDir . '/web/custom/' . $template;
            if (file_exists($file)) {
                $templateDir = $rootDir . '/web/custom/';
            }
        }
        $this->view->setTemplatesDirectory($templateDir);

        $this->view->appendData($data);
        $this->view->display($template);
    }

}