<?php

/**
 * login to protected area
 */
$app->map('/login/', function() use ($app) {

    $errors = array();
    $user   = '';
    $csrf   = \lib\SlimFunctions::genKey(40,true);
    $request= $app->request();

    if ($request->isPost()) {
        if (($request->post('csrf') != $_SESSION['csrf']) || ($_SESSION['csrf.expires'] < date("U"))) {
            $errors['csrf'] = 'Invalid form';
        } else {
            $_SESSION['csrf.expires'] += 60;
            $user = \app\models\core\Sanitize::email($request->post('user'));
            $user = Security\User::factory()->where('email',$user)->find_one();
            if ($user instanceof Security\User) {
                if ($user->pass != md5($request->post('pass'))) {
                    $errors['pass'] = 'Invalid password';
                } else {
                    $_SESSION['user.name']    = $user->email;
                    $_SESSION['app']['user']  = serialize($user);
                    unset($_SESSION['csrf']);
                    unset($_SESSION['csrf.expires']);
                    $app->redirect($app->urlFor('admin.index'));
                }
            } else {
                $errors['user'] = 'User don\'t exits';
            }
        }
    }
    $_SESSION['csrf'] = $csrf;
    $_SESSION['csrf.expires'] = date("U")+60*3;
    $app->render('frontend/home/login.html.twig',array(
        'user'  => $user,
        'csrf'  => $csrf,
        'errors'=> $errors,
    ));

})->via('GET','POST')->name('.login');

/**
 * logout
 */
$app->map('/logout/', function() use ($app) {

    unset($_SESSION['user.name']);
    unset($_SESSION['app']['user']);
    $app->redirect($app->urlFor('home.index'));

})->via('GET','POST')->name('.logout');
