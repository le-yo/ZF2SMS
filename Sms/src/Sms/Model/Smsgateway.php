<?php
namespace Sms\Model;

class Smsgateway
{
    public $id;
    // public $;
    // public $message_id;
    // public $from_number;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        // $this->message_id  = (!empty($data['message_id'])) ? $data['message_id'] : null;
        // $this->from_number  = (!empty($data['from_number'])) ? $data['from_number'] : null;
    }
}