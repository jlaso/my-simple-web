<?php


namespace app\models\core\Pagination;


interface PaginationRenderInterface
{

    public function __construct(Paginable $paginator);

    public function setOptions(array $options = array());

    public function render();


}