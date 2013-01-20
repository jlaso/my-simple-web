<?php

namespace Entity;

use app\models\core\BaseModel;
use app\models\core\ValidableInterface;
use lib\MyFunctions;

class Contact
    extends BaseModel
    implements ValidableInterface
{

    public function validate()
    {
        $result = array();
        // validar los contenidos de los campos
        if (empty($this->name)) {
            $result['name'] = $this->cantLeaveBlank(_('Name'));
        }
        if (empty($this->email)) {
            $result['email'] = $this->cantLeaveBlank(_('Email'));
        }
        if (empty($this->phone)) {
            $result['phone'] = $this->cantLeaveBlank(_('Phone'));
        }
        if (empty($this->message)) {
            $result['message'] = $this->cantLeaveBlank(_('Message'));
        }

        return $result;
    }

}
