<?php

    use lib\MyFunctions;
    use app\models\core\BaseModel;
    use app\models\core\ValidableInterface;
    use app\models\core\Pagination\Paginable;
    use app\models\core\Form\FormSearchTypeInterface;
    use app\models\core\Search\SearchQueryBuilder;

/**
 * lista entidades
 */
/*
$app->get('/admin/list/:entity/', function ($entity) use ($app) {

    $entity = Sanitize::string(trim(strtolower($entity)));
    $items  = BaseModel::factory(ucfirst($entity))->find_many();
    $app->render('backend/'.$entity.'/list.html.twig',array(
        'items'   => $items,
    ));
})->name('admin.list-entity');
*/

/**
 * crud - list generico para entidades que tengan definido un Entity\EntityFormType
 */
$app->map('/admin/list/:entity/(:page)', function($entity,$page=1) use ($app) {

    $entity      = \app\models\core\Sanitize::string(trim(strtolower($entity)));
    $ucEntity    = \lib\MyFunctions::underscoredToCamelCaseEntityName($entity);
    $frmLstClass = $ucEntity."FormType";
    if (class_exists($frmLstClass)) {

        $formList     = new $frmLstClass; //var_dump($formList->getFormList());

        if ($app->request()->isPost()) {
            $search = $app->request()->post('search');
            $qb     = new SearchQueryBuilder($formList->getSearchForm(),$search);
            $qb->buildQuery();
            $query  = $qb->getQuery();
            $params = $qb->getParams();
        }else{
            $search = null;
            $query  = null;
            $params = null;
        }

        if ($formList instanceof FormSearchTypeInterface) {
            $search = array(
                'form'   => $formList->getSearchForm(),
                'data'   => $search,
                'errors' => array(),
            );
        }else{
            $search = array(
                'form'   => array(),
                'data'   => array(),
                'errors' => array(),
            );
        }

        $paginator    = new Paginable($ucEntity,array(
            'query'     => $query,
            'params'    => $params,
            'recPerPage'=>10
        ));
        $paginator->setBaseRouteAndParams('admin.list-entity',array('entity'=>$entity));
        if (($page > 1) && ($page > $paginator->getPages())) {
            $app->notFound();
        }

        $paginator->setCurrentPage($page);

        $items = $paginator->getResults();

        $app->render('backend/entity/list.html.twig', array(
            'form'      => $formList->getFormList(),
            'search'    => $search,
            'items'     => $items,
            'entity'    => $entity,
            'paginator' => $paginator,
            'searchable'=> ($formList instanceof FormSearchTypeInterface),
            'entityName'=> $ucEntity::_entityName(),
        ));
    } else {
        $app->notFound();
    }

})->via('GET','POST')->name('admin.list-entity');
