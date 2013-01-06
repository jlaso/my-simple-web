<?php

    use lib\SlimFunctions;
    use app\models\core\BaseModel;
    use app\models\core\ValidableInterface;
    use app\models\core\Pagination\Paginable;
    use app\models\core\Form\FormSearchTypeInterface;
    use app\models\core\Seach\SearchQueryBuilder;

/**
 * check if exists yet an entity with provided slug
 */
$app->get('/admin/check-slug/:entity', function($entity) use ($app) {
    /*
        $entity = ucfirst(Sanitize::string(trim(strtolower($entity))););
        $slug   = strtolower(trim($app->request()->get('slug')));
        $id     = intval($app->request()->get('id'));
        $result = $entity::checkSlug($slug,$id);

        return
            SlimFunctions::jsonDataAnd200($app->response(),json_enconde(
                'slug'  => $slug,
                'id'    => $id,
                'result'=> $result,
            ));
    */
})->name('admin.check-slug');


