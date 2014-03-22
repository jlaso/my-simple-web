<?php

namespace Entity;

use app\models\core\BaseModel;
use app\models\core\ValidableInterface;
use lib\MyFunctions;
use Validate;


class Contact
    extends BaseModel
    implements ValidableInterface
{

    public function validate()
    {
        $result = array();
        // validar los contenidos de los campos
        if (empty($this->name)) {
            $result['name'] = Validate::cantLeaveBlank(_('Name'));
        }
        if (empty($this->email)) {
            $result['email'] = Validate::cantLeaveBlank(_('Email'));
        }
        if (empty($this->phone)) {
            $result['phone'] = Validate::cantLeaveBlank(_('Phone'));
        }
        if (empty($this->message)) {
            $result['message'] = Validate::cantLeaveBlank(_('Message'));
        }

        return $result;
    }

}
