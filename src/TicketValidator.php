<?php

namespace Yjtec\Cas;
use Illuminate\Validation\Validator;
class TicketValidator extends  Validator{
    public function __construct($translator, $data, $rules, $messages)
    {
        parent::__construct($translator, $data, $rules, $messages);
    }

    public function validateTicket($attribute, $value, $parameters, $validator)
    {
        //var_dump(app('request')->all());exit;
        return false;
    }

}