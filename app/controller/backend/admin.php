<?php

use app\models\core\BaseModel;

/**
 * checks if user has logged in
 *
 * @return bool
 */
function isLogged()
{
    return isset($_SESSION['user.name']);
}

/**
 * check if user was logged in and if not redirects to login page
 *
 * @param Slim\Slim $app
 */
function redirectIfNotLogged(\Slim\Slim $app)
{
    if (!isLogged()) {
        $app->redirect($app->urlFor('.login'));
    }
}

/**
 * retrieves all the entities
 *
 * @return ORM array
 */
function getAllEntities()
{
    return BaseModel::factory('Entity\Entity')->find_many();
}

/**
 * homepage for backend, without language specified
 */
$app->get('/admin/', function() use($app) {
    return $app->redirect($app->urlFor('admin.index',array(
        'lang'=> \lib\MyFunctions::session('lang'),
    )));
});

/**
 * homepage for backend
 */
$app->get('/:lang/admin/', function ($lang) use ($app) {
    redirectIfNotLogged($app);
    $app->render('backend/home/index.html.twig');
})->name('admin.index');

/**
 * helper for list all slim routes
 */
$app->get('/:lang/admin/get-all-routes/', function ($lang) use ($app) {
    redirectIfNotLogged($app);
    $routes = $app->router()->getNamedRoutes();
    /*
    foreach ($routes as $route) {
        // @var $route Slim\Route
        print($route->getName().' '.$route->getPattern().'<br/>');
    }
    */
    $app->render('backend/helper/get-all-routes.html.twig',array(
        'routes'   => $routes,
    ));
})->name('admin.get-all-routes');
