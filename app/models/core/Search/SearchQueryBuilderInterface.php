<?php


namespace app\models\core\Search;

interface SearchQueryBuilderInterface
{


    public function __construct(array $form, array $data);

    public function buildQuery();

    public function getQuery();

    public function getParams();


}