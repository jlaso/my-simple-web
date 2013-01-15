<?php

namespace app\models;

use \ORM;
use \app\models\core\Registry;

/**
 * This class is for
 */
class EntityManager
{

    private $conn;

    private $dbname;

    private $dump;

    public function __construct($dump = false)
    {
        $this->dump = $dump;
        require_once dirname(dirname(__FILE__)).'/config/dbconfig.php';
        $this->dbname = DBNAME; //.'_dev';
        $this->conn = mysql_connect(DBHOST,DBUSER,DBPASS,$this->dbname);

        ORM::configure('mysql:host='.DBHOST.';dbname='.$this->dbname);
        ORM::configure('username', DBUSER);
        ORM::configure('password', DBPASS);
    }

    /**
     * Execs the sql statement passed
     *
     * @param $sql
     */
    public function execute($sql)
    {
        if ($this->dump) {
            print $sql.PHP_EOL;
        }
        $result = mysql_query($sql,$this->conn);
        if (mysql_errno($this->conn)) {
           die($sql.PHP_EOL.mysql_error($this->conn).PHP_EOL);
        }
        return $result;
    }

    /**
     * Reads the contents of this dir and returns only dirs that are capitalized first letter
     *
     * @return array
     */
    public static function readdir()
    {
        $entries = array();

        foreach (scandir(__DIR__) as $entry)
        {
            if ($entry!='.' && $entry!='..' && is_dir(__DIR__.'/'.$entry)) {
                if ($entry == ucfirst($entry)) {
                    $entries[] = $entry;
                }
            }

        }
        return $entries;
    }

    /**
     * Forces the load of classes files contained in this dir
     *
     * @return void
     */
    public static function forceRequireEntityClasses()
    {
        $dirs = self::readdir();

        foreach ($dirs as $dir) {

            $subdir = __DIR__.'/'.$dir;
            $files  = scandir($subdir);

            foreach ($files as $file) {

                // only the php files that has the first letter capitalized
                if ($file!='.' && $file!='..' && preg_match('/\.php$/i',$file)) {

                    if ($file == ucfirst($file)) {

                        require_once $subdir.'/'.$file;
                    }

                }

            }
        }

    }

    /**
     * Drops database
     */
    public function dropDatabase()
    {
        $sql = 'DROP DATABASE IF EXISTS `'.$this->dbname.'`;';
        $this->execute($sql);

    }

    /**
     * Create database
     */
    public function createDatabase()
    {
        $sql = 'CREATE DATABASE IF NOT EXISTS `'.$this->dbname.'`;';
        $this->execute($sql);

    }

    /**
     * Select Database
     */
    public function selectDb()
    {
        mysql_select_db($this->dbname);
    }

    /**
     * Create tables
     */
    public function createTables()
    {
        self::forceRequireEntityClasses();

        $this->selectDb();
        // get entity classes that extends from BaseModel
        $classes = get_declared_classes();
        foreach($classes as $class)
        {
            if (is_subclass_of($class,'app\\models\\core\\BaseModel')) {
                if (method_exists($class,'getCreationSchema')) {
                    if ($this->dump) {
                        print $class.PHP_EOL;
                    }
                    //$sql = $class.'::getCreationSchema';
                    $sql = $class::getCreationSchema();
                    $this->execute($sql);
                }
            }

        }
    }

    /**
     * Generate fixtures for all entities
     */
    public function generateFixtures()
    {
        self::forceRequireEntityClasses();

        $ordered = array();

        // get entity classes that extends from FixturableInterface
        $classes = get_declared_classes();
        foreach($classes as $class)
        {
            //print $class.PHP_EOL;
            if (is_subclass_of($class,'app\\models\\core\\FixturableInterface')) {
                //print 'order '.$class::getOrder().' ';
                $ordered[sprintf("%05d-%s",$class::getOrder(),$class)] = $class;
            }

        }

        $this->selectDb();
        ksort($ordered);
        print PHP_EOL;

        //var_dump($ordered);

        $fixtureRegistry = new Registry();

        foreach($ordered as $order=>$class)
        {
            if ($this->dump) {
                print $order.PHP_EOL;
            }
            $fixtureClass = new $class;
            // @TODO pasar algo a generate fixture que permita crear referencias internas
            $fixtureClass->generateFixtures($fixtureRegistry);
        }


    }

}