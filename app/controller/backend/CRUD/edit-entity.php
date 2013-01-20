<?php

    use lib\MyFunctions;
    use app\models\core\BaseModel;
    use app\models\core\ValidableInterface;
    use app\models\core\Pagination\Paginable;
    use app\models\core\Form\FormSearchTypeInterface;
    use app\models\core\Seach\SearchQueryBuilder;


/**
 * crud - generic edit for entities
 *
 * New: now accept master-slave form
 *
 * @return
 */
$app->map('/:lang/admin/edit/:entity/:id', function($lang,$entity,$id) use ($app) {

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

        if ($request->isPost()) {
            $item->bind($request->post());
            if ($item instanceof ValidableInterface) {
                $errors = $item->validate();
            }

            if (!count($errors)) {
                $item->save();
                $app->redirect($app->urlFor('admin.list-entity',array('entity'=>$entity)));
            }
        }

        $app->render('backend/entity/edit.html.twig', array(
            'action'    => 'edit',
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

})->via('GET','POST')->name('admin.edit-entity');



