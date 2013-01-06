<?php


namespace app\models\core\Pagination;  // si se pone namespace no se puede invocar desde Twig !!

use app\models\core\Pagination\PaginableInterface;
use app\models\core\Pagination\PaginationRender;

class PaginatorViewExtension
{


    /**
     * Shows the paginator
     *
     * @param \app\models\core\PaginableInterface $paginator
     * @return mixed
     */
    public static function render(PaginableInterface $paginator)
    {
        $pagination = new PaginationRender($paginator);
        return $pagination->render();
    }


}