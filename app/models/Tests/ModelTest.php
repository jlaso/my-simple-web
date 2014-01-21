<?php

namespace app\models\Test;

use app\models\core\BaseModel;
use Entity\Article;
use \PHPUnit_Framework_TestCase;
require __DIR__ . '/../Entity/Article.php';

class ModelTest extends PHPUnit_Framework_TestCase
{


    /**
     * expectedException \RuntimeException
     */
    public function testBaseModel()
    {
        $this->setExpectedException('InvalidArgumentException');
        try{
           //$baseModel1 = BaseModel::factory('foo')->create();
           //$this->assertFalse( $baseModel1 instanceof BaseModel );
        }catch(\RuntimeException $e){
            die('asdad'.$e->getMessage());
        }
        $baseModel2 = BaseModel::factory('Article')->create();
        $this->assertTrue( $baseModel2 instanceof BaseModel );
        $this->assertTrue( $baseModel2 instanceof Article );

        $baseModel3 = BaseModel::factory('Description')->create();

    }


}