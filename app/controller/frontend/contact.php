<?php

/**
 * contact form
 */
$app->map('/contact/', function () use ($app) {

    $errors  = array();
    $contact = Contact::factory()->create();

    if ($app->request()->isPost()) {
        $sum = $_SESSION['sum'];
        $contact->hydrate($app->request()->post());
        $errors = $contact->validate();
        if (count($errors)==0) {
            if ($sum['one']+$sum['two']==$contact->suma) {
                $contact->save();
                $app->redirect($app->urlFor('.contact.thanks'));
            } else {
                $errors['sum'] = 'Sum error';
            }
        }
    } else {
        $sum = array(
            'one'   => rand(1,30),
            'two'   => rand(1,30),
        );
        $sum['result'] = $sum['one'] + $sum['two'];
        $_SESSION['sum'] = $sum;
    }
    $app->render('frontend/contact/index.html.twig',array(
        'contact'   => $contact,
        'sum'       => $sum,
        'errors'    => $errors,
    ));
})->via('GET','POST')->name('contact.index');

/**
 * thanks for contact
 */
$app->get('/contact/thanks', function () use ($app) {
    $app->render('frontend/contact/thanks.html.twig');
})->name('.contact.thanks');
