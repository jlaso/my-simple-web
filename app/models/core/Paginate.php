<?php

class Paginate
{

    /**
     * @var Slim\Http\Request
     */
    private $request;

    /**
     * @var string nombre de la clase que queremos paginar
     */
    private $class;

    /**
     * @var int numero total de registros que contiene ese modelo
     */
    private $numRecords;

    /**
     * @var int número de elementos que queremos en cada página
     */
    private $numElemPerPage;

    /**
     * @var float número de páginas totales que tenemos
     */
    private $pt;

    /**
     * @var int número de la página actual, viene como parámetro en el request
     */
    private $pa;

    /**
     * Tiene que devolver la colección con sólo los elementos que correspondan a la página solicitada
     *
     * @param \Slim\Http\Request $request
     * @param string             $class
     * @param int                $numElemPerPage
     * @param string             $filter
     */
    public function __construct(\Slim\Http\Request $request, $class, $numElemPerPage)
    {
        $this->request        = $request;
        $this->class          = $class;
        $this->numElemPerPage = $numElemPerPage;

        $this->numRecords     = Model::factory($class)->count();

        $this->pt             = 1+floor($this->numRecords / $numElemPerPage);
        $this->pa             = $request->get('pa');
        if(!$this->pa)
            $this->pa = 1;
    }

    /**
     * valor que hay que pasarle a la consulta como offset
     * @return int
     */
    public function getOffset()
    {
        return (($this->pa - 1) * $this->numElemPerPage);
    }

    /**
     * valor que hay que pasarle a la consulta como limit
     * @return int
     */
    public function getLimit()
    {
        return $this->numElemPerPage;
    }

    /**
     * devuelve el número de páginas que tiene la selección actual
     */
    public function getNumpages()
    {
        return $this->pt;
    }

    /**
     * devuelve el número de página actual
     */
    public function getPa()
    {
        return $this->pa;
    }

}
