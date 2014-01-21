<?php

namespace app\models\core;

/**
 * Permite que una entidad pueda tomar directamente los valores de un array asociativo,
 * por ejemplo el request e hidratarse con esos valores, para hacer un bind de un formulario
 */
interface BindableInterface
{

    /**
     * Devuelve los nombres de los campos que pueden ser binded desde un array asociativo
     * @return mixed
     */
    //public function getBindableFields();

    /**
     * Efectúa el bind de los parámetros pasados
     * @param  array $array
     * @return mixed
     */
    public function bind(array $array);

}
