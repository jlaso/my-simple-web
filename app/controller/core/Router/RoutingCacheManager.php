<?php

namespace Router;

use \Slim\Slim;

class RoutingCacheManager
{

    protected $cacheDir;

    function __construct()
    {
        $this->cacheDir = dirname(dirname(dirname(dirname(__FILE__)))) . '/cache/routing';
        @mkdir($this->cacheDir, 0777);
    }

    /**
     * This method writes the cache content into cache file
     *
     * @param $class
     * @param $content
     *
     * @return string
     */
    protected function writeCache($class, $content)
    {
        $content = '<?php' . PHP_EOL . PHP_EOL .
            '// Generated with RoutingCacheManager' . PHP_EOL . PHP_EOL .
            $content . PHP_EOL;
        $fileName = $this->cacheFile($class);
        file_put_contents($fileName, $content);

        return $fileName;
    }

    /**
     * Sets the modify time of cache file according to classfile
     *
     * @param $classFile
     */
    protected function setDateFromClassFile($classFile)
    {
        $className = $this->className($classFile);
        $cacheFile = $this->cacheFile($className);
        $fileDate  = filemtime($classFile);
        touch($cacheFile, $fileDate);
    }

    /**
     * gets the full path and the name of cache file
     *
     * @param $class
     *
     * @return string
     */
    protected function cacheFile($class)
    {
        return $this->cacheDir . '/' . $class . '.php';
    }

    /**
     * Extracts the className through the classfile name
     *
     * @param $classFile
     *
     * @return mixed
     * @throws \Exception
     */
    protected function className($classFile)
    {
        $parts = explode('/', $classFile);
        if(!count($parts)){
            throw new \Exception(sprintf('classFile "%s" passed has problems', $classFile));
        }
        $className = str_replace(".php", "", $parts[count($parts)-1]);

        return $className;
    }

    /**
     * Indicates if the classfile has a diferent modify time that cache file
     *
     * @param $classFile
     *
     * @return bool
     */
    protected function hasChanged($classFile)
    {
        $className = $this->className($classFile);
        $cacheFile = $this->cacheFile($className);
        $cacheDate = file_exists($cacheFile) ? filemtime($cacheFile) : 0;
        $fileDate  = filemtime($classFile);

        return ($fileDate != $cacheDate);
    }

    /**
     * @param $classFile
     *
     * @return string
     * @throws \Exception
     */
    protected function processClass($classFile)
    {
        $className = '';
        $content   = file_get_contents($classFile);
        $result    = '';

        preg_match_all('/class\s+(\w*)\s*(extends\s+)?([^{])*/s', $content, $mclass, PREG_SET_ORDER);
        $className = $mclass[0][1];
        if (!$className){
            throw new \Exception(sprintf('class not found in %s', $classFile));
        }

        preg_match_all('/(\/\*\*[^}]*})/', $content, $match, PREG_PATTERN_ORDER);

        foreach ($match[0] as $k => $m) {
            $function = '?';
            $comments = '';
            if (!substr_count($m, 'class')) {
                $function = substr_count($m, 'function') ? 'yes' : 'no';
                if ($function == 'yes') {
                    preg_match_all('/(\/\*\*.*\*\/)/s', $m, $mc, PREG_PATTERN_ORDER);
                    $comments = nl2br($mc[0][0]);
                    preg_match_all('/\*\/\s+(public\s+)?(static\s+)?function\s+([^\(]*)\(/s', $m, $mf, PREG_SET_ORDER);
                    $functionName = $mf[0][3];
                    preg_match_all("/\*\s+@Route\s*\('([^']*)'\)/s", $comments, $params, PREG_SET_ORDER);
                    $route = $params[0][1];
                    preg_match_all("/\*\s+@Method\s*\('([^']*)'\)/s", $comments, $params, PREG_SET_ORDER);
                    $method = isset($params[0][1]) ? strtoupper($params[0][1]) : 'GET';
                    preg_match_all("/\*\s+@Name\s*\('([^']*)'\)/s", $comments, $params, PREG_SET_ORDER);
                    $name = strtolower($params[0][1]);
                    $result .= sprintf(
                        '$app->map("%s", "%s::___%s")->via("%s")->name("%s");' . PHP_EOL,
                        $route, $className, $functionName, str_replace(',','","',$method), $name
                    );
                }
            }
        }

        return $result;
    }

    /**
     * Generates new file and return cachefile name
     * @param $classFile
     *
     * @return string
     */
    protected function updateAndGetCacheFileName($classFile)
    {
        $className = $this->className($classFile);
        if($this->hasChanged($classFile)){
            $content = $this->processClass($classFile);
            $this->writeCache($className, $content);
            $this->setDateFromClassFile($classFile);
        }

        return $this->cacheFile($className);
    }

    /**
     * Return cachefile contents
     *
     * @param $classFile
     *
     * @return string
     */
    protected function getCache($classFile)
    {
        return file_get_contents($this->updateAndGetCacheFileName($classFile));
    }

    /**
     * Process the cachefile, in PHP require is enough
     *
     * @param $classFile
     *
     * @throws \Exception
     */
    protected function processCache($classFile)
    {
        /** @var SlimExt $app */
        $app = SlimExt::getInstance();
        require_once($this->updateAndGetCacheFileName($classFile));
    }

    /**
     * Main method to invoke the routing system
     *
     * @param $phpFile
     */
    public function loadRoute($phpFile)
    {
        $prefix = '';
        if(preg_match('/^@(?<name>[^:]*?):(?<path>.*?)$/', $phpFile, $matches)){
            $map = require (ROOT_DIR . '/vendor/composer/autoload_namespaces.php');
            $name = str_replace('/', '\\', $matches['name']);
            if(isset($map[$name])){
                $prefix = (is_array($map[$name]) ? $map[$name][0] : $map[$name]) . '/' . $matches['name'] . '/app/controller/';
                $phpFile = $matches['path'];
            }
        }
        require_once $prefix . $phpFile;
        $this->processCache($prefix . $phpFile);
    }

}
