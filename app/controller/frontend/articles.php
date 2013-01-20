<?php

/**
 * show articles list
 */
$app->get('/:lang/articles(/)', function ($lang) use ($app) {

    $paginator = new app\models\core\Paginate($app->request(),'Entity\Article',3);

    $articles = Entity\Article::factory()
                    ->offset($paginator->getOffset())
                    ->limit($paginator->getLimit())
                    ->find_many();

    $app->render('frontend/articles/index.html.twig',array(
        'articles'     => $articles,
        'paginator'    => $paginator,
    ));
    
})->name('articles.index');


/**
 * Shows one article
 */
$app->get('/:lang/articles/:slug(/)', function ($lang, $slug) use ($app) {

    $slug    = Sanitize::string($slug);
    $article = Article::factory()
                ->where('slug',$slug)
                ->find_one();

    if (!$article instanceof Article) {

        $app->notFound('Article not found');

    }else{

        $app->render('frontend/articles/show.html.twig',array(
            'article'     => $article,
        ));
    }

})->name('articles.show');

