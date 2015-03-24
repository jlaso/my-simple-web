<?php

namespace lib;

use lib\MyFunctions;
use \PHPUnit_Framework_TestCase;

class MyFunctionsTest extends PHPUnit_Framework_TestCase
{

    /**
     * Check_email tests
     */
    public function testCheckEmail()
    {
        // check_mail assertions
        $this->assertTrue( MyFunctions::check_email('email@email.com') );
        // email that is only word
        $this->assertFalse( MyFunctions::check_email('emailinvalid') );
        // email that hasn't domain termination
        $this->assertFalse( MyFunctions::check_email('email@invalid') );
    }

    public function NotContains($str,$not)
    {
        return !(boolean) preg_match("/[{$not}]/i",$str);
    }

    public function testNotContains()
    {
        $this->assertTrue( $this->NotContains('abcd','m|j') );
        $this->assertFalse( $this->NotContains('abcd','a|j') );
        $this->assertFalse( $this->NotContains('áé','á|a') );
    }

    public function testSlug()
    {
        $text = 'This a text with áéíóúàèìòùÁÉÍÓÚñÑçÇ';
        $slug = MyFunctions::slug($text);
        $this->assertTrue( $this->NotContains($slug,'á| |é|í|ó|ú|à|è|ì|ò|ù|Á|É|Í|Ó|Ú|ñ|Ñ|ç|Ç') );
    }

    public function testGenkey()
    {
        $test = MyFunctions::genKey(7);
        // verifies lenght
        $this->assertTrue( 7 === strlen($test) );

        // and that is string
        $this->assertTrue( is_string($test) );

        // now verifies than matches in repeated generation is less than 10%
        $matches = 0;
        for ($i=0;$i<1000;$i++){
            if ($test == MyFunctions::genKey(7)){
                $matches++;
            }
        }

        $this->assertTrue( $matches < 10 );

    }

    public function testCamelCase()
    {
        $test = "ThisIsATestForKnow";

        $this->assertTrue( 'this_is_a_test_for_know' == MyFunctions::camelCaseToUnderscored($test));

        $test = "entity_table_name";
        $this->assertTrue("Entity\\TableName" == MyFunctions::underscoredToCamelCaseEntityName($test));

    }

}