<?php


require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class WebTest extends PHPUnit_Extensions_SeleniumTestCase
{

    protected $captureScreenshotOnFailure = TRUE;
    protected $screenshotPath = '/tmp/screenshots';
    protected $screenshotUrl = 'http://localhost/tmp-screenshots';

    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://msw.dev/');
    }

    public function testTitle()
    {
        $this->url('http://msw.dev/');
        $this->assertEquals('1My simple page', $this->title());
    }

}
