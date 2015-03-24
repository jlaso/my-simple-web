<?php

namespace lib;

use Router\SlimExt;
use \Slim\Views\Twig as TwigView;
use Symfony\Component\Yaml\Yaml;

class Twig extends TwigView
{

    const TWIG_YML = '/app/config/twig.yml';
    /**
     * @var TwigEnvironment The Twig environment for rendering templates.
     */
    private $parserInstance = null;

    /**
     * Creates new TwigEnvironment if it doesn't already exist, and returns it.
     *
     * @return \Twig_Environment
     */
    public function getInstance()
    {
        if (!$this->parserInstance) {
            /**
             * Check if Twig_Autoloader class exists
             * otherwise include it.
             */
            if (!class_exists('\Twig_Autoloader')) {
                require_once $this->parserDirectory . '/Autoloader.php';
            }

            \Twig_Autoloader::register();
            $loader = new \Twig_Loader_Filesystem($this->getTemplateDirs());

            if(file_exists(ROOT_DIR . self::TWIG_YML)){
                $namespaces = SlimExt::getNamespacesMap();
                $params = Yaml::parse(file_get_contents(ROOT_DIR . self::TWIG_YML));
                $twigNS = $params['namespaces'];
                foreach($twigNS as $tns=>$ns){
                    if(isset($namespaces[$ns])){
                        $loader->addPath($namespaces[$ns][0] . '/' . str_replace(array("\\",'\\'),'/',$ns) . '/templates', $tns);
                    }
                }
            }

            $this->parserInstance = new \Twig_Environment(
                $loader,
                $this->parserOptions
            );

            foreach ($this->parserExtensions as $ext) {
                $extension = is_object($ext) ? $ext : new $ext;
                $this->parserInstance->addExtension($extension);
            }
        }

        return $this->parserInstance;
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * Get a list of template directories
     *
     * Returns an array of templates defined by self::$twigTemplateDirs, falls
     * back to Slim\View's built-in getTemplatesDirectory method.
     *
     * @return array
     **/
    private function getTemplateDirs()
    {
        if (empty($this->twigTemplateDirs)) {
            return array($this->getTemplatesDirectory());
        }
        return $this->twigTemplateDirs;
    }


}
