<?php
namespace Sms\Model;

class SmsSwitchData
{
    public $action_id;
    public $prefix;
    public $message;
    //public $from_number;

    public function exchangeArray($data)
    {
        $this->action_id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->prefix = (!empty($data['prefix'])) ? $data['prefix'] : null;
        $this->message  = (!empty($data['message'])) ? $data['message'] : null;
        //$this->from_number  = (!empty($data['from_number'])) ? $data['from_number'] : null;
    }
}