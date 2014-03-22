<?php

require __DIR__ . '/../TddSample.php';

class TddSampleTest extends PHPUnit_Framework_TestCase
{

    public function testPruebaTdd1()
    {
        $object = new TddSample();
        $this->assertNotEquals(null, $object->pruebaTdd1());

    }

    public function testPruebaTdd2()
    {
        $object = new TddSample();
        $this->assertNotEquals(null, $object->pruebaTdd2());

    }

    public function testPruebaTdd3()
    {
        $object = new TddSample();
        $result = "" . $object->pruebaTdd3();
        $this->assertNotEquals(null, $result);
        $this->assertEquals(6, strlen($result));
        $this->assertTrue((bool)preg_match('/\d{6}/', $result));

    }

    public function hasRepetitions($valueToTest)
    {
        $stats = count_chars("".$valueToTest, 1);
        foreach ($stats as $i => $val) {
            if($val > 1){
                return true;
            }
        }

        return false;
    }

    public function testPruebaTdd4()
    {
        $object = new TddSample();
        $result = "" . $object->pruebaTdd3();
        $this->assertNotEquals(null, $result);
        $this->assertEquals(6, strlen($result));
        $this->assertTrue((bool)preg_match('/\d{6}/', $result));
        $this->assertFalse($this->hasRepetitions($result));
    }

    public function testPruebaTdd5()
    {
        $object = new TddSample();
        $result = "" . $object->pruebaTdd4();
        $this->assertNotEquals(null, $result);
        $this->assertEquals(6, strlen($result));
        $this->assertTrue((bool)preg_match('/\d{6}/', $result));
        $this->assertFalse($this->hasRepetitions($result));
    }

}