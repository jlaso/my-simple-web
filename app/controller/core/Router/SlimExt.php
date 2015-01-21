<?php


namespace Router;

use \Slim\Slim;

class SlimExt extends Slim
{
    protected $namespacesMap;
    protected $rootDir;

    /**
     * @param array $userSettings
     */
    public function __construct(array $userSettings = array())
    {
        $this->rootDir = dirname(dirname(dirname(dirname(__DIR__))));
        $this->namespacesMap = require ($this->rootDir . '/vendor/composer/autoload_namespaces.php');

        return parent::__construct($userSettings);
    }

    /**
     * @return mixed
     */
    public function getNamespacesMap()
    {
        return $this->namespacesMap;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
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
        if (!is_null($status)) {
            $this->response->status($status);
        }

        $rootDir = $this->getRootDir();
        $templates = self::config('templates.path');

        $loader = new \Twig_Loader_Filesystem($templates);
        foreach($this->getNamespacesMap() as $namespace=>$path){
            $loader->addPath($path, $namespace);
        }
        $twig = new Twig_Environment($loader);

        if(preg_match('/^@(?<name>[^:]*?):(?<path>.*?)$/', $template, $matches)){
            $map = $this->getNamespacesMap();
            $name = str_replace('/', '\\', $matches['name']);
            if(isset($map[$name])){
                $prefix = (is_array($map[$name]) ? $map[$name][0] : $map[$name]) . '/' . $matches['name'] . '/templates/';
                $path = $matches['path'];
                var_dump($rootDir . '/web/custom/' . $matches['name'] . '/' . $path, $prefix . $path); die;
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
            }else{
                $templateDir = $templates;
            }
        }
        $this->view->setTemplatesDirectory($templateDir);

        $this->view->appendData($data);
        $this->view->display($template);
    }

}