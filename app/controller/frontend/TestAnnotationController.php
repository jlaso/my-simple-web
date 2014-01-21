<?php

use Router\Controller;

class TestAnnotationController extends Controller
{

    /**
     * @Route('/test/one')
     * @Name('test1')
     */
    public function test1Action()
    {
        die('test one');
    }

    /**
     * @Route('/test/hello/:name')
     * @Name('test_hello')
     */
    public function testHelloAction($name)
    {
        die('Hello ' . $name . '!');
    }

    /**
     * @Route('/test/redirect')
     * @Name('test_redirect')
     */
    public function testRedirectAction()
    {
        $app = $this->getSlim();
        $app->redirect($app->urlFor('test_hello', array('name'=>'Joseluis')));
    }

}