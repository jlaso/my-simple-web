<?php

namespace app\models\core\Pagination;

use Slim\Slim;
use Exception;
use app\models\core\BaseModel;
use ORM;

/**
 * show sample in twig template
 * ============================
 *
 * <div class="pagination span8" id="paginator" style="text-align:right;">
 *  <ul>
 *      {% for page in 1..paginator.pages %}
 *      <li>
 *          <a href="{{ paginator.routeForPage(page) }}">{{ page }}</a>
 *      </li>
 *      {% endfor %}
 *  </ul>
 * </div>
 */
class Paginable implements PaginableInterface
{

    private $entity;
    private $query;
    private $params;
    private $page;
    private $pages;
    private $nbRecords;
    private $recPerPage;
    private $route;
    private $routeParams;

    /**
     * Generates a paginator from the ORMWrapper specified with ten records per page as default
     *
     * @param string $entity
     * @param array  $_options
     *
     */
    public function __construct($entity, $_options = array())
    {
        $options = array_merge(array(
            'query'     => null,
            'params'    => null,
            'recPerPage'=> 10,
        ),$_options);

        $this->entity     = $entity;
        $this->query      = $options['query'];
        $this->params     = $options['params'];

        if ($this->query && $this->params) {
            $this->nbRecords  = BaseModel::factory($entity)
                ->where_raw($this->query,$this->params)
                ->count();
        }else{
            $this->nbRecords  = BaseModel::factory($entity)->count();
        }
        $this->setNumRecPerPage($options['recPerPage']);
    }

    /**
     * Returns the items for the page selected
     *
     * @return ORM ArrayCollection
     */
    public function getResults()
    {
        if ($this->page>0) {
            $start  = ($this->page-1) * $this->recPerPage;
            if (($start >= 0) && ($this->recPerPage > 0)){
                if ($this->query && $this->params) {
                    $result = BaseModel::factory($this->entity)
                        ->where_raw($this->query,$this->params)
                        ->offset($start)
                        ->limit($this->recPerPage)
                        ->find_many();

                    return $result;
                }else{
                    return BaseModel::factory($this->entity)
                        ->offset($start)
                        ->limit($this->recPerPage)
                        ->find_many();
                }
            }
        }
    }

    /**
     * Set the records per page desired
     *
     * @param int $num
     */
    public function setNumRecPerPage($num)
    {
        $this->recPerPage = $num;
        $this->pages      = intval(ceil($this->nbRecords / $this->recPerPage));
    }

    /**
     * sets the current page
     *
     * @param $page
     *
     * @throws \Exception
     */
    public function setCurrentPage($page)
    {
        $page = intval($page);
        if (!is_int($page)) {
            throw new Exception('El número de página indicado no es correcto');
        }
        if ($page < 1) {
            throw new Exception('El número de página indicado no es correcto');
        }
        $this->page = $page;
    }

    /**
     * obtains total page number
     *
     * @return mixed
     */
    public function  getPages()
    {
        return $this->pages;
    }

    /**
     * obtains the current page
     * @return mixed
     *
     */
    public function getCurrentPage()
    {
        return $this->page;
    }

    /**
     * Set the base route and params to generate route for each page
     *
     * @param $route
     * @param $params
     */
    public function setBaseRouteAndParams($route, $params = array())
    {
        $this->route       = $route;
        $this->routeParams = $params;
    }

    /**
     * returns the route for specified page
     *
     * @param int $num
     * @return string
     */
    public function getRouteForPage($num)
    {
        /** @var Slim $app */
        $app = Slim::getInstance();

        $params = array_merge(array('page'=>intval($num)),$this->routeParams);
        return $app->urlFor($this->route, $params);
    }

    /**
     * @return bool
     */
    public function needPagination()
    {
        return $this->nbRecords > $this->recPerPage;
    }


    /**
     * @return bool
     */
    public function hasPreviousPage()
    {
        return $this->page > 1;
    }

    /**
     * @return int
     * @throws LogicException
     */
    public function getPreviousPage()
    {
        if (!$this->hasPreviousPage()) {
            throw new LogicException('There is not previous page.');
        }

        return $this->page - 1;
    }

    /**
     * @return bool
     */
    public function hasNextPage()
    {
        return $this->page < $this->pages;
    }

    /**
     * @return int
     * @throws LogicException
     */
    public function getNextPage()
    {
        if (!$this->hasNextPage()) {
            throw new LogicException('There is not next page.');
        }

        return $this->page + 1;
    }

    /**
     * @return int
     */
    public function getNbRecords()
    {
        return $this->nbRecords;
    }

}