<?php

use lib\MyFunctions;
use app\models\core\BaseModel;
use app\models\core\ValidableInterface;
use app\models\core\Pagination\Paginable;
use app\models\core\Form\FormSearchTypeInterface;
use app\models\core\Seach\SearchQueryBuilder;

/**
 *
 */
$app->get('/:lang/:entity/list(/:page)', function($lang,$entity,$page=1) use($app) {

    die('hey');

})->name('home.list-entity');

/**
 * Show entity
 *
 * @return
 */
$app->get('/:lang/:entity/:id', function($lang,$entity,$id) use ($app) {

    $request     = $app->request();
    $entity      = \app\models\core\Sanitize::string(trim(strtolower($entity)));
    $ent         = \lib\MyFunctions::underscoredToCamelCaseEntityName($entity);
    $id          = intval(trim($id));
    $frmLstClass = $ent."FormType";
    if (class_exists($frmLstClass)) {
        $formList    = new $frmLstClass;

        $item  = BaseModel::factory($ent)->find_one($id);
        $errors= array();

        $relations = $item->_relations();
        $slaves = isset($relations['one-to-many']) ? $relations['one-to-many'] : array();
        $relations = array();
        foreach ( $slaves as $slave => $entityRelation ) {
            if ($slave) {
                $formType = $entityRelation."FormType";
                if (class_exists($formType)) {
                    $slaveForm = new $formType();
                    $getSlave  = 'get' . ucfirst($slave);
                    $data      = $item->$getSlave();
                    $relations[] = array(
                        'name'  => $slaveForm->_namePlural(),
                        'entity'=> $slaveForm->_nameEntity(),
                        'form'  => $slaveForm->getFormList(),
                        'data'  => $data,
                    );
                }
            }
        }

        $app->render('frontend/entity/show.html.twig', array(
            'form'      => $formList->getForm(),
            'item'      => $item,
            'entity'    => $entity,
            'errors'    => $errors,
            'entityName'=> $ent::_entityName(),
            'relations' => $relations,
        ));
    } else {
        $app->pass();
    }

})->name('home.show-entity');



