<?php

class TddSample
{

    public function pruebaTdd1()
    {
        // El método más simple no pasará el test
    }

    // Hacemos que devuelva algo fijo, y ya pasa el primer test
    public function pruebaTdd2()
    {
        return "1";
    }

    // Hacemos que devuelva algo fijo y que sea de 6 dígitos
    public function pruebaTdd3()
    {
        return "111111";
    }

    public function pruebaTdd4()
    {
        $digits = array(0,1,2,3,4,5,6,7,8);
        shuffle($digits);

        return implode("",array_slice($digits,0,6));
    }

} 