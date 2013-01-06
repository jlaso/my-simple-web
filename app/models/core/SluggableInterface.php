<?php

namespace app\models\core;

interface SluggableInterface
{

    public static function checkSlug($slug,$id=0);

}
