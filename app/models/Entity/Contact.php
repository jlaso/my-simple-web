<?php

namespace Entity;

use app\models\core\BaseModel;
use app\models\core\ValidableInterface;
use lib\SlimFunctions;

class Contact
    extends BaseModel
    implements ValidableInterface
{

    public function validate()
    {
        $result = array();
        // validar los contenidos de los campos
        if (empty($this->name)) {
            $result['name'] = 'Can\'t left blank name field';
        }
        if (empty($this->email)) {
            $result['email'] = 'Can\'t left blank email field';
        }
        if (empty($this->phone)) {
            $result['phone'] = 'Can\'t left blank phone field';
        }
        if (empty($this->message)) {
            $result['message'] = 'Can\'t left blank message field';
        }

        return $result;
    }

}
