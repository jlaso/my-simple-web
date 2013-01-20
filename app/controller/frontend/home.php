<?php

/**
 * ruta de la home (index)
 */
$app->get('/(:lang(/))', function ($lang='en') use ($app) {
    $app->render('frontend/home/index.html.twig');
})->name('home.index');

/**
 *
 */
$app->get('/:lang/:slug(/)', function ($lang, $slug) use ($app) {

    $static = Entity\Staticpage::factory()
        ->where('slug',$slug)
        ->find_one();
    if (!$static instanceof Entity\Staticpage) {
        return $app->pass();
    }
    $app->render('frontend/home/staticpage.html.twig',array(
        'static'  => $static,
    ));

})->name('home.staticpage');

/**
 * generates on-fly the sitemap.xml file
 */
$app->get('/:lang/sitemap.xml', function () use ($app) {

    $entityConversion = array(
        'articles'      => 'Article',
        'staticpage'    => 'Staticpage',
    );

    $f_home    = filemtime('../app/templates/frontend/home/index.html.twig');
    $base      = 'http://my-simple-web.ns0.es';
    $urls      = array();
    $routes    = array();
    $allRoutes = $app->router()->getNamedRoutes();
    foreach ($allRoutes as $route) {
        // @var $route Slim\Route
        $name    = $route->getName();
        $pattern = $route->getPattern();
        $names   = explode('.',$name);
        if ($names[0]!='' && $names[0]!='admin') {

            if (preg_match('/:slug/i',$pattern)) {

                foreach ($entityConversion as $convert=>$entity) {
                    if (in_array($convert,$names)) {

                        $items = \app\models\core\BaseModel::factory($entity)->find_many();

                        foreach ($items as $item){
                            if ($item->slug){
                                $urls[] = array(
                                                'loc'     => $base.$app->urlFor($name,array('slug'=>$item->slug)),
                                                'lastmod' => $f_home,
                                                );
                            }
                        }
                    }
                }

            }else{
                $urls[] = array(
                    'loc'    => $base.$app->urlFor($route->getName()),
                    'lastmod'=> $f_home,
                );
            }

        }

    }
    $app->render('frontend/sitemap.xml.twig',array('urls'=>$urls));
});
