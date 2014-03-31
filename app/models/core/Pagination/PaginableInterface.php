<?php

namespace app\models\core\Pagination;

interface PaginableInterface
{

    /**
     * Generates a paginator from the ORMWrapper specified with ten records
     * per page as default
     *
     * @param string $entity
     * @param array  $_options
     */
    public function __construct($entity, $_options = array());

    /**
     * Returns the items for the page selected
     *
     * @return ORM ArrayCollection
     */
    public function getResults();

    /**
     * Set the records per page desired
     *
     * @param int $num
     */
    public function setNumRecPerPage($num);

    /**
     * sets the current page
     *
     * @param $page
     */
    public function setCurrentPage($page);

    /**
     * obtains total page number
     *
     * @return mixed
     */
    public function  getPages();

    /**
     * obtains the current page
     * @return mixed
     *
     */
    public function getCurrentPage();

    /**
     * Set the base route and params to generate route for each page
     *
     * @param $route
     * @param $params
     */
    public function setBaseRouteAndParams($route, $params);

    /**
     * returns the route for specified page
     *
     * @param int $num
     * @return string
     */
    public function getRouteForPage($num);

    /**
     * returns true if number of records is greater than recPerPage
     *
     * @return bool
     */
    public function needPagination();

    /**
     * returns true if currentPage is not the first
     *
     * @return bool
     */
    public function hasPreviousPage();

    /**
     * returns the number of previous page
     *
     * @return int
     */
    public function getPreviousPage();

    /**
     * returns true if currentPage are not the last
     *
     * @return int
     */
    public function hasNextPage();

    /**
     * returns the number of the next page
     *
     * @return int
     */
    public function getNextPage();


}